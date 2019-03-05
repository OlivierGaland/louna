#!/usr/bin/env python3
import os,time,filecmp

H265_WORKDIR = '/mnt/video'

EXT_TOPROCESS = 'avi'
EXT_SWAP = 'swap'
EXT_INWORK = 'tmp'
EXT_PROCESSED = 'mkv'

def split_filepath(fp):
    d , f = os.path.split(fp)
    t = f.rsplit('.',1)
    if len(t) == 1:
        return d,f,None
    else:
        return d,t[0],t[1]

def delete_tmp(filepathname):
    print("Warning: tmp file found : "+filepathname)
    print("Deleting "+filepathname)
    os.remove(filepathname)

def process_file(directory,filename):
    try:
        do_break = False
        start = os.path.join(directory,filename)+'.'+EXT_TOPROCESS
        swap = start+'.'+EXT_SWAP
        tmp = os.path.join(directory,filename)+'.'+EXT_INWORK+'.'+EXT_PROCESSED
        destination = os.path.join(directory,filename)+'.h265.'+EXT_PROCESSED
        print("Processing "+start+" -> "+destination)
        if os.path.isfile(destination):
            print("Already processed : "+start)
            return False
        if os.path.isfile(tmp):
            delete_tmp(tmp)
            do_break = True
        #Check if in use (md5sum constant)
        pid = os.getpid()
        size1 = os.system('md5sum "'+start+'" > /tmp/h265_1.'+str(pid))
        time.sleep(10)
        size2 = os.system('md5sum "'+start+'" > /tmp/h265_2.'+str(pid))
        compare = filecmp.cmp('/tmp/h265_1.'+str(pid),'/tmp/h265_2.'+str(pid))
        os.remove('/tmp/h265_1.'+str(pid))
        os.remove('/tmp/h265_2.'+str(pid))
        if not compare:
            print("File currently modified, skipping : "+start)
            return False
        ret = os.system('ffmpeg -i "'+start+'" -c:v libx265 -crf 25 -c:a libfdk_aac -vbr 5 "'+tmp+'"')
        print("Encoding done, result = "+str(ret))
        if ret == 0:
            os.rename(tmp,destination)
        return do_break
    except Exception as e:
        print("Exception on swap creation, skipping file : "+str(e))
        return False

while True:
    file_list = []

    try:
        for root, subdirs, files in os.walk(H265_WORKDIR):
            for file in files:
                file_list.append(os.path.join(root,file))

        for f in file_list:
            directory , filename , extension =  split_filepath(f)
            if extension is not None and filename != '':
                filepathname = os.path.join(directory,filename)+'.'+extension
                if extension == EXT_PROCESSED:
                    t = filename.rsplit('.',1)
                    if len(t) > 1 and t[1] == EXT_INWORK:
                        delete_tmp(filepathname)
                elif extension == EXT_TOPROCESS:
                    if process_file(directory,filename) == True:
                        break
                elif extension == EXT_SWAP:
                    print("Warning: swap file found : "+filepathname)
                    destination = os.path.join(directory,filename)
                    print("Renaming "+filepathname+" -> "+destination)
                    os.rename(filepathname,destination)
                else:
                    print("Skipping "+filepathname)
    except Exception as e:
        print("Exception : "+str(e))
    print("Sleep state 1 minute")
    time.sleep(10)


