#include <vector>
#include <string>

using namespace std;

typedef LPTHREAD_START_ROUTINE THREAD;

void errex(const char *err);
int mmrand(int min, int max);
unsigned short csum(unsigned short *buf, int nwords);
unsigned short ip_checksum(unsigned short *buf, int nwords);
vector<string> Explode(const string &delimiter, const string &str);

THREAD SendThread();

int NumCores();