/*
    Copyright 2007,2008 Luigi Auriemma

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA

    http://www.gnu.org/licenses/gpl-2.0.txt
*/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdint.h>
#include <stdarg.h>
#include <time.h>
#include <ctype.h>

#ifdef WIN32
    #include <direct.h>
    #include <ws2tcpip.h>
    #include <winsock.h>
    #include "winerr.h"

    #define close       closesocket
    #define sleep       Sleep
    #define in_addr_t   uint32_t
    #define ONESEC      1000
#else
    #include <unistd.h>
    #include <sys/socket.h>
    #include <sys/types.h>
    #include <arpa/inet.h>
    #include <netdb.h>
    #include <sys/ioctl.h>
    #include <net/if.h>
    #include <pthread.h>

    #define ONESEC      1
    #define strnicmp    strncasecmp
    #define stricmp     strcasecmp
#endif

#ifdef WIN32
    #define quick_thread(NAME, ARG) DWORD WINAPI NAME(ARG)
    #define thread_id   DWORD
#else
    #define quick_thread(NAME, ARG) void *NAME(ARG)
    #define thread_id   pthread_t
#endif

thread_id quick_threadx(void *func, void *data) {
    thread_id       tid;
#ifdef WIN32
    if(!CreateThread(NULL, 0, func, data, 0, &tid)) return(0);
#else
    pthread_attr_t  attr;
    if(pthread_attr_init(&attr)) return(0);
    pthread_attr_setdetachstate(&attr, PTHREAD_CREATE_DETACHED);
    pthread_attr_setstacksize(&attr, 1<<18); //PTHREAD_STACK_MIN);
    if(pthread_create(&tid, &attr, func, data)) return(0);
#endif
    return(tid);
}

typedef uint8_t     u8;
typedef uint16_t    u16;
typedef uint32_t    u32;



#define VER             "0.2.1"
#define BUFFSZ          0xffff                      // for speed and for any UDP packet
#define PORT            8123
#define MAXDNS          512
#define MAXWAIT         120                         // max timeout for any connection

#define KEEPALIVE                                   // HTTP connections with the remote hosts
                                                    // will be kept active till client or
                                                    // server disconnection or timeout
                                                    // this option is very useful with websites
                                                    // full of images

#define SEND(A,B,C)     if(send(A, B, C, 0) < 0) goto quit
#define RECV(A,B,C)     recv(A, B, C, 0)

#define HTTPOK          "HTTP/1.0 200 OK\r\n\r\n"
#define HTTPERROR       "HTTP/1.0 500 ERROR\r\n\r\n"
#define SOCKS4ERROR     "\x04" "\x5b" "\x00\x00" "\x00\x00\x00\x00"
#define SOCKS5ERROR     "\x05" "\x01" "\x00" "\x01" "\x00\x00\x00\x00" "\x00\x00"



int bind_tcp_socket(struct sockaddr_in *peer, in_addr_t iface);
int bind_udp_socket(struct sockaddr_in *peer, in_addr_t iface);
int handle_http(int sock, int sd, u8 *buff, struct sockaddr_in *peer, int *tunnel);
int handle_socks4(int sock, int sd, u8 *buff, struct sockaddr_in *peer);
int handle_socks5(int sock, int sd, u8 *buff, struct sockaddr_in *peer);
int handle_socks5_udp(int sock, int socku, u8 *buff, struct sockaddr_in *peerl);
quick_thread(client, int sock);
int tcp_string_recv(int sd, u8 *buff, int buffsz);
int tcp_recv(int sd, u8 *buff, int len);
int myconnect(int sock, int sd, u8 *host, in_addr_t ip, u16 port, struct sockaddr_in *peer);
int parse_http(int sock, u8 *buff, int buffsz, u8 **ret_req, u8 **ret_host, u16 *ret_port, u8 **ret_uri);
u8 *find_string(u8 *buff, int buffsz, u8 *str);
int timeout(int sock);
in_addr_t resolv(char *host);
in_addr_t dnsdb(char *host);
u8 *strduplow(u8 *str);
in_addr_t *get_ifaces(void);
in_addr_t get_sock_ip_port(int sd, u16 *port);
void sock_printf(int sd, char *fmt, ...);
void open_log(u8 *fname);
void std_err(void);



static char verbose     = 0;
in_addr_t   lhost       = INADDR_ANY,
            Lhost       = INADDR_ANY,
            *lifaces    = NULL;
FILE        *fdlog      = NULL;



int main(int argc, char *argv[]) {
    struct  sockaddr_in peer,
                        peer_bind;
    u16     lport   = PORT;
    int     sdl,
            sda,
            i,
            psz;

#ifdef WIN32
    WSADATA    wsadata;
    WSAStartup(MAKEWORD(1,0), &wsadata);
#endif

    setbuf(stdout, NULL);
    setbuf(stderr, NULL);

    fputs("\n"
        "Proxymini "VER"\n"
        "by Luigi Auriemma\n"
        "e-mail: aluigi@autistici.org\n"
        "web:    aluigi.org\n"
        "\n", stdout);

    lifaces = get_ifaces();

    printf(
        "Options:\n"
        "-l IP    local interface to bind (default any), list of local IP availables:\n"
        "         ");
    for(i = 0; lifaces[i] != INADDR_NONE; i++) {
        printf("%s ", inet_ntoa(*(struct in_addr *)&lifaces[i]));
    }
    printf("\n"
        "-L IP    as above but works only for the outgoing socket, this means you can\n"
        "         decide to use a secondary interface for connecting to the hosts (for\n"
        "         example using a Wireless connection instead of your main one)\n"
        "-p PORT  local port to bind, default %hu\n"
        "-v       verbose logging on standard output (default is none)\n"
        "-o FILE  logs everything in the file FILE, it's just as -v but for file\n"
        "\n", lport);

    for(i = 1; i < argc; i++) {
        if(((argv[i][0] != '-') && (argv[i][0] != '/')) || (strlen(argv[i]) != 2)) {
            printf("\nError: wrong argument (%s)\n", argv[i]);
            exit(1);
        }
        switch(argv[i][1]) {
            case '-':
            case '?':
            case 'h': {
                exit(1);
                } break;
            case 'l': {
                if(!argv[++i]) exit(1);
                lhost       = resolv(argv[i]);
                if(lhost == INADDR_NONE) std_err();
                } break;
            case 'L': {
                if(!argv[++i]) exit(1);
                Lhost       = resolv(argv[i]);
                if(Lhost == INADDR_NONE) std_err();
                } break;
            case 'p': {
                if(!argv[++i]) exit(1);
                lport       = atoi(argv[i]);
                } break;
            case 'v': {
                verbose     = 1;
                } break;
            case 'o': {
                if(!argv[++i]) exit(1);
                open_log(argv[i]);
                } break;
            default: {
                printf("\nError: wrong argument (%s)\n", argv[i]);
                exit(1);
            }
        }
    }

    peer_bind.sin_port = htons(lport);
    sdl = bind_tcp_socket(&peer_bind, lhost);
    if(sdl < 0) std_err();
    printf("- ready for HTTP, HTTP CONNECT, SOCKS4 and SOCKS5 (both TCP and UDP)\n");

    dnsdb(NULL);

    for(;;) {
        psz = sizeof(struct sockaddr_in);
        sda = accept(sdl, (struct sockaddr *)&peer, &psz);
        if(sda < 0) {
            sock_printf(0, "- accept() failed, continue within one second\n");
            close(sdl);
            sleep(ONESEC);
            sdl = bind_tcp_socket(&peer_bind, lhost);
            if(sdl < 0) std_err();
            continue;
        }

        sock_printf(sda, "connected\n");

        if(!quick_threadx(client, (void *)sda)) {
            sock_printf(sda, "unable to create thread\n");
            close(sda);
        }
    }

    close(sdl);
    if(fdlog) fclose(fdlog);
    return(0);
}



int bind_tcp_socket(struct sockaddr_in *peer, in_addr_t iface) {
    int     sd  = -1,
            psz,
            on  = 1;

    peer->sin_addr.s_addr = iface;
    if(peer->sin_port) {
        printf("- bind %s:%hu\n", inet_ntoa(peer->sin_addr), ntohs(peer->sin_port));
    } else {
        peer->sin_port    = 0;
    }
    peer->sin_family      = AF_INET;

    sd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
    if(sd < 0) goto quit;

    if(peer->sin_port) {
        if(setsockopt(sd, SOL_SOCKET, SO_REUSEADDR, (char *)&on, sizeof(on))
          < 0) goto quit;
    }

    if(bind(sd, (struct sockaddr *)peer, sizeof(struct sockaddr_in))
      < 0) goto quit;

    psz = sizeof(struct sockaddr_in);
    if(getsockname(sd, (struct sockaddr *)peer, &psz)
      < 0) goto quit;

    if(listen(sd, SOMAXCONN)
      < 0) goto quit;

    return(sd);
quit:
    if(sd > 0) close(sd);
    sock_printf(0, "bind_tcp_socket() failed\n");
    return(-1);
}



int bind_udp_socket(struct sockaddr_in *peer, in_addr_t iface) {
    int     sd  = -1,
            psz;

    peer->sin_addr.s_addr = iface;
    peer->sin_port        = 0;
    peer->sin_family      = AF_INET;

    sd = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP);
    if(sd < 0) goto quit;

    if(bind(sd, (struct sockaddr *)peer, sizeof(struct sockaddr_in))
      < 0) goto quit;

    psz = sizeof(struct sockaddr_in);
    if(getsockname(sd, (struct sockaddr *)peer, &psz)
      < 0) goto quit;

    return(sd);
quit:
    if(sd > 0) close(sd);
    sock_printf(0, "bind_udp_socket() failed\n");
    return(-1);
}



/*
some info about variable names:
sock = the socket of the client which is connected to us
sd   = any outgoing socket
sdl  = listening socket, it's temporary
*/


int handle_socks4(int sock, int sd, u8 *buff, struct sockaddr_in *peer) {
    struct sockaddr_in peerl;
    in_addr_t   ip;
    int     sdl     = 0,
            psz;
    u16     port;
    u8      cmd;
    char    ntoa[16],
            *host   = NULL;

    if(tcp_recv(sock, buff, 7) < 0) goto quit;      // read CMD, PORT, IP

    cmd  = buff[0];
    port = (buff[1] << 8) | buff[2];
    ip   = *(in_addr_t *)(buff + 3);

    if(tcp_string_recv(sock, buff, 256)             // read USERID
      < 0) goto quit;

    if(!(ntohl(ip) >> 8)) {                         // SOCKS 4a
        if(tcp_string_recv(sock, buff, 256)         // read hostname
          < 0) goto quit;
        host = buff;
    }

    if(cmd == 0x01) {                               // tcp connection
        strcpy(ntoa, inet_ntoa(*(struct in_addr *)&ip));
        sock_printf(sock, "SOCKS4 TCP %s:%hu\n",
            host ? host : ntoa,
            port);

        sd = myconnect(sock, sd, host, ip, port, peer);
        if(sd < 0) goto quit;
        ip = get_sock_ip_port(sd, &port);           // useless
        if(ip == INADDR_NONE) goto quit;

    } else if(cmd == 0x02) {                        // tcp bind
        sock_printf(sock, "SOCKS4 TCP binding\n");

        peerl.sin_port = 0;
        sdl = bind_tcp_socket(&peerl, lhost);
        if(sdl < 0) goto quit;
        ip   = get_sock_ip_port(sock, NULL);
        if(ip == INADDR_NONE) goto quit;
        port = ntohs(peerl.sin_port);

        sock_printf(sock, "SOCKS4 TCP assigned port %hu\n", port);

    } else {
        sock_printf(sock, "SOCKS4 command 0x%02x not supported\n", cmd);
        goto quit;
    }

    buff[0] = 0;                                    // version, must be 0
    buff[1] = 90;                                   // success
    buff[2] = port >> 8;                            // port
    buff[3] = port;
    *(in_addr_t *)(buff + 4) = ip;
    SEND(sock, buff, 8);

    if(cmd == 0x02) {
        psz = sizeof(struct sockaddr_in);
        if(timeout(sdl) < 0) goto quit;
        sd = accept(sdl, (struct sockaddr *)&peerl, &psz);
        if(sd < 0) goto quit;

        sock_printf(sd, "SOCKS4 connected to TCP bound port %hu\n", port);
    }

    return(sd);
quit:
    //sock_printf(0, "handle_socks4() failed\n");
    return(-1);
}



int handle_socks5(int sock, int sd, u8 *buff, struct sockaddr_in *peer) {
    struct sockaddr_in  peerl;
    in_addr_t   ip;
    int     sdl     = 0,
            len,
            psz;
    u16     port;
    u8      cmd,
            type;
    char    ntoa[16],
            *host   = NULL;

    if(tcp_recv(sock, buff, 1) < 0) goto quit;      // methods
    if(tcp_recv(sock, buff, buff[0]) < 0) goto quit;

    buff[0] = 0x05;
    buff[1] = 0x00;                                 // force no auth!
    SEND(sock, buff, 2);

    if(tcp_recv(sock, buff, 4) < 0) goto quit;

    cmd  = buff[1];
    type = buff[3];

    if(type == 0x01) {
        if(tcp_recv(sock, buff, 4) < 0) goto quit;
        ip = *(in_addr_t *)buff;

    } else if(type == 0x03) {
        if(tcp_recv(sock, buff, 1) < 0) goto quit;  // host length
        len = buff[0];                              // host
        if(tcp_recv(sock, buff, len) < 0) goto quit;
        buff[len] = 0;
        host = buff;

    } else if(type == 0x04) {
        sock_printf(sock, "IPv6 not supported\n");
        goto quit;

    } else {
        sock_printf(sock, "SOCKS5 address type 0x%02x not supported\n", type);
        goto quit;
    }

    if(tcp_recv(sock, (void *)&port, 2) < 0) goto quit;
    port = htons(port);

    if(cmd == 0x01) {                               // tcp connect
        strcpy(ntoa, inet_ntoa(*(struct in_addr *)&ip));
        sock_printf(sock, "SOCKS5 TCP %s:%hu\n",
            host ? host : ntoa,
            port);

        sd = myconnect(sock, sd, host, ip, port, peer);
        if(sd < 0) goto quit;
        ip = get_sock_ip_port(sd, &port);
        if(ip == INADDR_NONE) goto quit;

    } else if(cmd == 0x02) {                        // tcp bind
        sock_printf(sock, "SOCKS5 TCP binding\n");

        peerl.sin_port = 0;
        sdl = bind_tcp_socket(&peerl, lhost);
        if(sdl < 0) goto quit;
        ip   = get_sock_ip_port(sock, NULL);
        if(ip == INADDR_NONE) goto quit;
        port = ntohs(peerl.sin_port);

        sock_printf(sock, "SOCKS5 TCP assigned port %hu\n", port);

    } else if(cmd == 0x03) {                        // udp
        sock_printf(sock, "SOCKS5 UDP binding\n");

        peerl.sin_port = 0;
        sdl = bind_udp_socket(&peerl, lhost);
        if(sdl < 0) goto quit;
        ip   = get_sock_ip_port(sock, NULL);
        if(ip == INADDR_NONE) goto quit;
        port = ntohs(peerl.sin_port);

        sock_printf(sock, "SOCKS5 UDP assigned port %hu\n", port);

    } else {
        sock_printf(sock, "SOCKS5 command 0x%02x not supported\n", cmd);
        goto quit;
    }

    buff[0] = 0x05;                                 // version
    buff[1] = 0x00;                                 // reply, success
    buff[2] = 0x00;                                 // reserved
    buff[3] = 0x01;                                 // IPv4
    *(in_addr_t *)(buff + 4) = ip;                  // IP
    buff[8] = port >> 8;                            // port
    buff[9] = port;

    SEND(sock, buff, 10);

    if(cmd == 0x02) {
        psz = sizeof(struct sockaddr_in);
        if(timeout(sdl) < 0) goto quit;
        sd = accept(sdl, (struct sockaddr *)&peerl, &psz);
        if(sd < 0) goto quit;

        sock_printf(sd, "SOCKS5 connected to TCP bound port %hu\n", port);

    } else if(cmd == 0x03) {
        handle_socks5_udp(sock, sdl, buff, &peerl); // this is a totally new function
        return(-1);                                 // that's why I quit here... do not modify!
    }

    return(sd);
quit:
    //sock_printf(0, "handle_socks5() failed\n");
    return(-1);
}



int handle_socks5_udp(int sock, int socku, u8 *buff, struct sockaddr_in *peerl) {
    struct sockaddr_in  peer;
    in_addr_t   ip;
    struct  timeval tout;
    fd_set  rset;
    int     sd      = -1,
            sel,
            len,
            datasz,
            psz;
    u16     port;
    u8      *data,
            *host;

    sd = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP);
    if(sd < 0) goto quit;
    peerl->sin_addr.s_addr = Lhost;
    peerl->sin_port        = 0;
    peerl->sin_family      = AF_INET;
    if(bind(sd, (struct sockaddr *)peerl, sizeof(struct sockaddr_in))
      < 0) goto quit;

    sel = sock + socku + sd + 1;

    for(;;) {
        FD_ZERO(&rset);
        FD_SET(sock,  &rset);
        FD_SET(socku, &rset);
        FD_SET(sd,    &rset);
        tout.tv_sec  = MAXWAIT;
        tout.tv_usec = 0;
        if(select(sel, &rset, NULL, NULL, &tout)
          <= 0) goto quit;

        if(FD_ISSET(sock, &rset)) {                 // used only to take udp active
            len = RECV(sock, buff, BUFFSZ);
            if(len <= 0) goto quit;
        }

        if(FD_ISSET(socku, &rset)) {                // from udp client
            psz = sizeof(struct sockaddr_in);
            len = recvfrom(socku, buff, BUFFSZ, 0, (struct sockaddr *)peerl, &psz);
            if(len < 7) continue;                   // 7 is the minimum!

                                                    // no, I don't check if the host is valid or not!

            if(buff[0] || buff[1]) continue;        // reserved, must be 0

            if(buff[2]) {                           // fragments not supported
                continue;
            }

            if(buff[3] == 0x01) {
                ip     = *(in_addr_t *)(buff + 4);
                port   = (buff[8] << 8) | buff[9];
                data   = buff + 10;
                datasz = len  - 10;
                if(datasz < 0) continue;

            } else if(buff[3] == 0x03) {
                host   = buff + 5;
                data   = buff + 5 + buff[4] + 2;
                port   = (data[-2] << 8) | data[-1];
                datasz = len  - (data - buff);
                if(datasz < 0) continue;

                host[buff[4]] = 0;
                ip = dnsdb(host);

            } else if(buff[3] == 0x04) {
                continue;

            } else {
                continue;
            }

            if(ip == INADDR_NONE) continue;
            if(!port) continue;

            peer.sin_addr.s_addr = ip;
            peer.sin_port        = htons(port);
            peer.sin_family      = AF_INET;

            sendto(sd, data, datasz, 0, (struct sockaddr *)&peer, sizeof(struct sockaddr_in));
        }

        if(FD_ISSET(sd, &rset)) {                   // from udp server
            psz = sizeof(struct sockaddr_in);
            len = recvfrom(sd, buff + 10, BUFFSZ - 10, 0, (struct sockaddr *)&peer, &psz);
            if(len < 0) continue;

            buff[0] = 0x00;                         // probably useless, all 0x00 is ok too
            buff[1] = 0x00;
            buff[2] = 0x00;
            buff[3] = 0x01;
            *(in_addr_t *)(buff + 4) = peer.sin_addr.s_addr;
            *(u16 *)(buff + 8)  = peer.sin_port;

            sendto(socku, buff, 10 + len, 0, (struct sockaddr *)peerl, sizeof(struct sockaddr_in));
        }
    }

quit:
    if(sd > 0) close(sd);
    close(socku);
    return(0);
}



int handle_http(int sock, int sd, u8 *buff, struct sockaddr_in *peer, int *tunnel) {
    int     t,
            len,
            ulen,
            hlen,
            rlen;
    u16     port;
    u8      *req,
            *host,
            *uri,
            *p;

    len = 1;                                        // get header (one byte already read!)
    do {
        if(timeout(sock) < 0) goto quit;
        t = RECV(sock, buff + len, BUFFSZ - len);
        if(t <= 0) goto quit;
        len += t;

        p = find_string(buff, len, "\r\n\r\n");
    } while(!p);
    hlen = (p + 4) - buff;

    ulen = parse_http(sock, buff, hlen, &req, &host, &port, &uri);
    if(ulen < 0) goto quit;

    sock_printf(sock, "%s %s:%hu/%s\n", req, host, port, uri);

    sd = myconnect(sock, sd, host, INADDR_NONE, port, peer);
    if(sd < 0) goto quit;

    if(!stricmp(req, "CONNECT")) {
        *tunnel = 1;
        SEND(sock, HTTPOK, sizeof(HTTPOK) - 1);
    } else {                                        // send header
        *tunnel = 0;
        SEND(sd, req,           strlen(req));
        SEND(sd, " /",          2);
        SEND(sd, uri,           strlen(uri));
        SEND(sd, " ",           1);
        SEND(sd, buff + ulen,   hlen - ulen);
    }

    rlen = 0;                                       // remaining data
    p = find_string(buff + ulen, hlen - ulen, "\nContent-Length:");
    if(p) rlen = atoi(p + 16);

    len -= hlen;                                    // how much long is the rest we have?
    if(len < 0) goto quit;
    rlen -= len;                                    // how much we need to download yet?
    if(rlen < 0) goto quit;

    SEND(sd, buff + hlen,   len);                   // send the data we still have

    for(len = BUFFSZ; rlen; rlen -= t) {            // recv data (content-length)
        if(len > rlen) len = rlen;
        if(timeout(sock) < 0) goto quit;
        t = RECV(sock, buff, len);
        if(t <= 0) goto quit;
        SEND(sd, buff,          t);                 // send data
    }

    return(sd);
quit:
    return(-1);
}



quick_thread(client, int sock) {
    struct  sockaddr_in peer;
    struct  timeval tout;
    fd_set  rset;
    int     sd,
            sel,
            len,
            tunnel;
    u8      *buff;

    sd   = 0;
    buff = NULL;
    memset(&peer, 0, sizeof(struct sockaddr_in));

    buff = malloc(BUFFSZ);
    if(!buff) goto quit;

    for(;;) {
        if(tcp_recv(sock, buff, 1) < 0) goto quit;

        if(buff[0] == 0x04) {
            sd = handle_socks4(sock, sd, buff, &peer);
            if(sd < 0) goto quit;
            tunnel = 1;

        } else if(buff[0] == 0x05) {
            sd = handle_socks5(sock, sd, buff, &peer);
            if(sd < 0) goto quit;
            tunnel = 1;

        } else {
            sd = handle_http(sock, sd, buff, &peer, &tunnel);
            if(sd < 0) goto quit;
        }

        sel = sock + sd + 1;                        // start recv

        for(;;) {
            FD_ZERO(&rset);
            FD_SET(sock, &rset);
            FD_SET(sd,   &rset);
            tout.tv_sec  = MAXWAIT;
            tout.tv_usec = 0;
            if(select(sel, &rset, NULL, NULL, &tout)
              <= 0) goto quit;

            if(FD_ISSET(sock, &rset)) {             // local port
                if(!tunnel) break;                  // we must re-handle the request
                len = RECV(sock, buff, BUFFSZ);
                if(len <= 0) goto quit;
                SEND(sd, buff, len);
            }

            if(FD_ISSET(sd, &rset)) {               // dest port
                len = RECV(sd, buff, BUFFSZ);
                if(len <= 0) {
#ifdef KEEPALIVE
                    if(tunnel) goto quit;           // break if CONNECT
                    close(sd);                      // we want ever keep-alive???
                    sd = 0;
                    break;
#else
                    goto quit;
#endif
                }
                SEND(sock, buff, len);
            }
        }
    }

quit:
    if(buff) free(buff);
    sock_printf(sock, "disconnected\n");
    if(sd > 0) close(sd);
    close(sock);
    return(0);
}



int tcp_string_recv(int sd, u8 *buff, int buffsz) {
    int     i;

    for(i = 0; i < buffsz; i++) {
        if(timeout(sd) < 0) return(-1);
        if(RECV(sd, buff + i, 1)
          <= 0) return(-1);
        if(!buff[i]) return(i);
    }
    return(-1); // no NULL no party
}



int tcp_recv(int sd, u8 *buff, int len) {
    int     t;

    while(len) {
        if(timeout(sd) < 0) return(-1);
        t = RECV(sd, buff, len);
        if(t <= 0) return(-1);
        buff += t;
        len  -= t;
    }
    return(0);
}



int myconnect(int sock, int sd, u8 *host, in_addr_t ip, u16 port, struct sockaddr_in *peer) {
    struct sockaddr_in  peerl;
    int     i;

    if(host) {
        ip = dnsdb(host);
        if(ip == INADDR_NONE) {                     // host is invalid
            sock_printf(sock, "unknown host \"%s\"\n", host);
            return(-1); // do not use goto quit!
        }
    }
    // else use the ip provided

    port = htons(port);
                                                    // IP or port is not the previous one
    if((sd > 0) && ((peer->sin_addr.s_addr != ip) || (peer->sin_port != port))) {
        close(sd);
        sd = 0;
    }

    if(sd <= 0) {
        for(i = 0; lifaces[i] != INADDR_NONE; i++) {
            if(ip == lifaces[i]) {
                sock_printf(sock, "loopback connections not allowed\n");
                /* while connections to LAN hosts are allowed */
                goto quit;
            }
        }

        peer->sin_addr.s_addr = ip;
        peer->sin_port        = port;
        peer->sin_family      = AF_INET;

        sd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
        if(sd < 0) goto quit;
        peerl.sin_addr.s_addr = Lhost;
        peerl.sin_port        = 0;
        peerl.sin_family      = AF_INET;
        if(bind(sd, (struct sockaddr *)&peerl, sizeof(struct sockaddr_in))
          < 0) goto quit;
        if(connect(sd, (struct sockaddr *)peer, sizeof(struct sockaddr_in))
          < 0) goto quit;
    }
    return(sd);
quit:
    if(sd > 0) close(sd);
    return(-1);
}



int parse_http(int sock, u8 *buff, int buffsz, u8 **ret_req, u8 **ret_host, u16 *ret_port, u8 **ret_uri) {
    u16     port    = 80;
    u8      *req,
            *host,
            *uri,
            *p,
            *limit;

    req = buff;

    host = find_string(buff, buffsz, " ");
    if(!host) return(-1);
    *host++ = 0;

    limit = find_string(host, buffsz - (host - buff), " ");
    if(!limit) return(-1);
    *limit++ = 0;

    p = strstr(host, "://");                        // get host
    if(p) {
        *p = 0;
        if(stricmp(host, "http")) {
            sock_printf(sock, "protocol \"%s\" not supported\n", host);
            return(-1);
        }
        host = p + 3;
    }

    uri = host;

    p = host + strcspn(host, ":/");                 // get port
    if(*p == ':') {
        *p++ = 0;
        port = atoi(p);
        uri = p + strcspn(p, "/");
    } else {
        uri = p;
    }
    if(*uri) *uri++ = 0;

    *ret_req    = req;
    *ret_port   = port;
    *ret_host   = host;
    *ret_uri    = uri;
    return(limit - buff);
}



u8 *find_string(u8 *buff, int buffsz, u8 *str) {
    int     strsz;
    u8      *limit;

    strsz = strlen(str);
    limit = buff + buffsz - strsz;

    for(; buff <= limit; buff++) {
        if(!strnicmp(buff, str, strsz)) return(buff);
    }
    return(NULL);
}



int timeout(int sock) {
    struct  timeval tout;
    fd_set  fd_read;
    int     err;

    tout.tv_sec  = MAXWAIT;
    tout.tv_usec = 0;
    FD_ZERO(&fd_read);
    FD_SET(sock, &fd_read);
    err = select(sock + 1, &fd_read, NULL, NULL, &tout);
    if(err < 0) return(-1); //std_err();
    if(!err) return(-1);
    return(0);
}



in_addr_t resolv(char *host) {
    struct      hostent *hp;
    in_addr_t   host_ip;

    host_ip = inet_addr(host);
    if(host_ip == INADDR_NONE) {
        hp = gethostbyname(host);
        if(hp) host_ip = *(in_addr_t *)(hp->h_addr);
    }
    return(host_ip);
}



    /* the following function caches the IP addresses    */
    /* actually the instructions which replace the older */
    /* entries are not the best in the world... but work */

in_addr_t dnsdb(char *host) {
    typedef struct {
        in_addr_t   ip;
        u8          *host;
        time_t      time;
    } db_t;

    static db_t *db;
    static int  older;
    in_addr_t   fastip;
    int         i;

    if(!host) {
        db = malloc(sizeof(db_t) * MAXDNS);         // allocate
        if(!db) std_err();

        for(i = 0; i < MAXDNS; i++) {
            db[i].ip   = INADDR_NONE;
            db[i].host = NULL;
            db[i].time = time(NULL);
        }

        older = 0;
        return(0);
    }

    if(!host[0]) return(INADDR_NONE);

    fastip = inet_addr(host);
    if(fastip != INADDR_NONE) return(fastip);

    for(i = 0; i < MAXDNS; i++) {
        if(!db[i].host) break;                      // new host to add

        if(!strcmp(db[i].host, host)) {             // host in cache
            db[i].time = time(NULL);                // update time
            return(db[i].ip);
        }

        if(db[i].time < db[older].time) {           // what's the older entry?
            older = i;
        }
    }

    if(i == MAXDNS) i = older;                      // take the older one

    if(db[i].host) free(db[i].host);

    db[i].ip   = resolv(host);
    if(db[i].ip == INADDR_NONE) {
        db[i].host = NULL;
        return(INADDR_NONE);
    }

    db[i].host = strduplow(host);                   // low case!

    db[i].time = time(NULL);

    return(db[i].ip);
}



u8 *strduplow(u8 *str) {
    u8     *p;

    str = strdup(str);
    for(p = str; *p; p++) {
        *p = tolower(*p);
    }
    return(str);
}



in_addr_t *get_ifaces(void) {
#ifdef WIN32
    #define ifr_addr        iiAddress.AddressIn
#else
    struct ifconf   ifc;
    #define INTERFACE_INFO  struct ifreq
#endif

    struct sockaddr_in  *sin;
    INTERFACE_INFO  *ifr;
    int         sd,
                i,
                j,
                num;
    in_addr_t   *ifaces,
                lo;
    u8          buff[sizeof(INTERFACE_INFO) * 16];

    sd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
    if(sd < 0) std_err();

#ifdef WIN32
    if(WSAIoctl(sd, SIO_GET_INTERFACE_LIST, 0, 0, buff, sizeof(buff), (void *)&num, 0, 0)
      < 0) std_err();
    ifr = (void *)buff;
#else
    ifc.ifc_len = sizeof(buff);
    ifc.ifc_buf = buff;
    if(ioctl(sd, SIOCGIFCONF, (char *)&ifc)
      < 0) std_err();
    num = ifc.ifc_len;
    ifr = ifc.ifc_req;
#endif

    num /= sizeof(INTERFACE_INFO);
    close(sd);

    ifaces = malloc(sizeof(in_addr_t) * (num + 2)); // num + lo + NULL
    if(!ifaces) std_err();

    lo = inet_addr("127.0.0.1");

    for(j = i = 0; i < num; i++) {
        sin = (struct sockaddr_in *)&ifr[i].ifr_addr;

        if(sin->sin_family      != AF_INET)     continue;
        if(sin->sin_addr.s_addr == INADDR_NONE) continue;

        ifaces[j++] = sin->sin_addr.s_addr;

        if(sin->sin_addr.s_addr == lo) lo = INADDR_NONE;
    }

    ifaces[j++] = lo;
    ifaces[j]   = INADDR_NONE;

    return(ifaces);
}



in_addr_t get_sock_ip_port(int sd, u16 *port) {
    struct sockaddr_in  peer;
    int     psz;

    psz = sizeof(struct sockaddr_in);

    if(getsockname(sd, (struct sockaddr *)&peer, &psz)
      < 0) peer.sin_addr.s_addr = INADDR_NONE;

    if(port) *port = ntohs(peer.sin_port);

    return(peer.sin_addr.s_addr);
}



in_addr_t get_peer_ip_port(int sd, u16 *port) {
    struct sockaddr_in  peer;
    int     psz;

    psz = sizeof(struct sockaddr_in);

    if(getpeername(sd, (struct sockaddr *)&peer, &psz) < 0) {
        peer.sin_addr.s_addr = 0;                   // avoids possible problems
        peer.sin_port        = 0;
    }

    if(port) *port = ntohs(peer.sin_port);

    return(peer.sin_addr.s_addr);
}



void sock_printf(int sd, char *fmt, ...) {
    in_addr_t   ip;
    va_list ap;
    int     len;
    u16     port;
    u8      buff[1024];                             // unfortunately its needed for a "one line show"... blah

    if(!verbose && !fdlog) return;

    if(sd > 0) ip = get_peer_ip_port(sd, &port);

    len = sprintf(buff, "  ");
    va_start(ap, fmt);
    if(sd > 0) len = sprintf(buff, "%s:%hu ", inet_ntoa(*(struct in_addr *)&ip), port);
    len += vsnprintf(buff + len, sizeof(buff) - len - 1, fmt, ap);
    va_end(ap);

    if((len < 0) || (len >= sizeof(buff))) {
        strcpy(buff + sizeof(buff) - 6, "...\n");
    }

    if(verbose) {
        fputs(buff, stdout);
    }

    if(fdlog) {
        fputs(buff, fdlog);
        fflush(fdlog);
    }
}



void open_log(u8 *fname) {
    struct  tm  *tmx;
    time_t  datex;

    printf("- open/append log file %s\n", fname);
    fdlog = fopen(fname, "ab");
    if(!fdlog) std_err();

    time(&datex);
    tmx = localtime(&datex);
    fprintf(fdlog,
        "----------------------------------\n"
        "Log file appended at:\n"
        "  %02d/%02d/%02d   (dd/mm/yy)\n"
        "  %02d:%02d:%02d\n"
        "----------------------------------\n"
        "\n",
        tmx->tm_mday, tmx->tm_mon + 1, tmx->tm_year % 100,
        tmx->tm_hour, tmx->tm_min, tmx->tm_sec);
    fflush(fdlog);
}



#ifndef WIN32
    void std_err(void) {
        perror("\nError");
        exit(1);
    }
#endif


