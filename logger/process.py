import numpy as np
import scipy as sp
import base64
from operator import itemgetter

# Data
# ['permalink', 'currentview', 'ip', 'referer', 'posttype', 'time', 'viewstate']

def exists_in_values(find_str, kv):
    for k, v in kv.items():
        if find_str in v:
            return True
    return False

f = open("log.txt")

counts = {}
data = []

for line in f:
    parts = line.split(',')
    kv = {}
    for part in parts:
        secs = part.split(':')
        k = secs[0]
        kv[k] = base64.b64decode(secs[1])
    data.append(kv)
        
clean = []
for kv in data:
    if not exists_in_values('csail', kv) and \
       not exists_in_values('localhost', kv) and \
       not exists_in_values('marcua', kv) and \
       not exists_in_values('eob', kv) and \
       not exists_in_values('redwater', kv) and \
       not exists_in_values('datapress.local', kv) and \
       not exists_in_values('127.0.0.1', kv) and \
       not exists_in_values('192.168.', kv):
        clean.append(kv)

for kv in clean:
    # Take Counts
    for header,col in kv.items(): 
        if header not in counts:
            counts[header] = {}
        if col not in counts[header]:
            counts[header][col] = 0
        counts[header][col] = counts[header][col] + 1


# Display counts
print "Counts ========================================"
print "==============================================="
for k,v in counts.items():
    srt = sorted(v.items(), key=itemgetter(1), reverse=True)
    tot = sum([s[1] for s in srt])    
    print "%s (%d unique possibilities, summing to %d)" % (k, len(v), tot)
    print "----------------------------------------------"
    for s in srt:
        print "%d (%f %%) %s" % (s[1], (float(s[1])/float(tot)), s[0])
    print
    print


{
    'permalink': 'http://projects.csail.mit.edu/datapress/demosite/?p=43', 
    'currentview': 'inline', 
    'ip': '58.63.94.177',
    'referer': 'http://projects.csail.mit.edu/datapress/demosite/wp-content/plugins/datapress/wp-exhibit-only.php?iframe&exhibitid=8&postid=43&currentview=inline', 
    'posttype': 'post', 
    'time': '1277129466', 
    'viewstate': 'inline'
}
