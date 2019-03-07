#!/usr/bin/env python3
import os,time,filecmp,argparse
import xml.etree.ElementTree as ET

def split_filepath(fp):
    d , f = os.path.split(fp)
    t = f.rsplit('.',1)
    if len(t) == 1:
        return d,f,None
    else:
        return d,t[0],t[1]

def delete_tmp(filepathname):
    print("Warning: tmp file found, deleting : "+filepathname)
    os.remove(filepathname)

def process_file(directory,filename,extension):
    try:
        start = os.path.join(directory,filename)+'.'+extension
        tmp = os.path.join(directory,filename)+'.'+EXT_INWORK+'.'+EXT_PROCESSED
        destination = os.path.join(directory,filename)+'.'+FILE_TAG+'.'+EXT_PROCESSED
        print("Processing "+start+" -> "+destination)
        if os.path.isfile(destination):
            print("Already processed, skipping")
            return
        if os.path.isfile(tmp):
            delete_tmp(tmp)
        #Check if in use (md5sum constant, this is horribly unoptimized, but could prevent start to encode a file being uploaded on nfs mount)
        pid = os.getpid()
        size1 = os.system('md5sum "'+start+'" > /tmp/'+FILE_TAG+'_1.'+str(pid))
        time.sleep(10)
        size2 = os.system('md5sum "'+start+'" > /tmp/'+FILE_TAG+'_2.'+str(pid))
        compare = filecmp.cmp('/tmp/'+FILE_TAG+'_1.'+str(pid),'/tmp/'+FILE_TAG+'_2.'+str(pid))
        os.remove('/tmp/'+FILE_TAG+'_1.'+str(pid))
        os.remove('/tmp/'+FILE_TAG+'_2.'+str(pid))
        if not compare:
            print("File currently modified, temporarily skipping : "+start)
            return
        ret = os.system('ffmpeg -i "'+start+'" '+TRANSCODE_PARAMETERS+' "'+tmp+'" > /var/www/site/ffmpeg.txt 2>&1')
        print("Encoding done, result = "+str(ret))
        if ret == 0:
            os.rename(tmp,destination)
    except Exception as e:
        print("Exception : "+str(e))

try:
    parser = argparse.ArgumentParser()
    parser.add_argument("profile", help="Transcoding profile (without xml extension)")
    parser.add_argument("tag", help="Tag to append on transcoded files")
    args = parser.parse_args()
    FILE_TAG = 'louna_'+args.tag

    profile = ET.parse('/var/www/site/python/profiles/'+args.profile+'.xml').getroot()
    EXT_PROCESSED = profile.find('out_type').text
    TRANSCODE_PARAMETERS = profile.find('parameters').text
    
    settings = ET.parse('/var/www/site/python/settings.xml').getroot()
    WORKDIR = settings.find('input_dir').text
    EXT_INWORK = settings.find('in_work_tag').text
    EXT_TOPROCESS = settings.find('input_type_list').text.split(" ")
except Exception as e:
    print("Exception : "+str(e))

while True:
    file_list = []
    try:
        for root, subdirs, files in os.walk(WORKDIR):
            for file in files:
                file_list.append(os.path.join(root,file))

        for f in file_list:
            directory , filename , extension =  split_filepath(f)

            if extension is not None and filename != '':
                filepathname = os.path.join(directory,filename)+'.'+extension
                t = filename.rsplit('.',1)

                if len(t) > 1:
                    if 'louna_' in t[-1]:
                        continue
                    elif t[-1] == EXT_INWORK:
                        delete_tmp(filepathname)
                        continue
                
                if extension in EXT_TOPROCESS:
                    process_file(directory,filename,extension)
                
    except Exception as e:
        print("Exception : "+str(e))

    print("Sleep state 1 minute")
    time.sleep(60)


