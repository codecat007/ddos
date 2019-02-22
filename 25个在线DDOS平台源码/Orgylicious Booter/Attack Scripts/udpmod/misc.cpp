#include <Windows.h>
#include <stdio.h>
#include <time.h>

void errex(const char *err)
{
	printf("%s!\n", err);
	WSACleanup();
	getchar();
	exit(1);
}

unsigned short ip_checksum(unsigned short *buf, int nwords)
{
	unsigned long sum;
	for (sum = 0; nwords > 0; nwords--)
		sum += *buf++;
	sum = (sum >> 16) + (sum & 0xffff);
	sum += (sum >> 16);
	return ~sum;
}

int mmrand(int min, int max)
{
	return rand()%((min-max)+1)+min;
}