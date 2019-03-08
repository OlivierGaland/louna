# Louna transcoder daemon
Louna is a web based video transcoder daemon provided in a docker image including ffmpeg with x265 support.
Once daemon is started it will monitor one or more volumes and transcode the videos inside in the selected format.
You can add more videos in the watched directory(ies) and they will be processed when possible. 

Prerequesite :
- Host computer running docker
- Videos directory(ies) available mounted on the host

Installation procedure :
- Get the source code from github in your download dir
- Build the docker image : cd (your download dir) ; docker build -t louna .  
  example : cd /home/ogaland/samba/docker/louna/ ; docker build -t louna .
- Run the image : docker run -v (host path to monitor):/mnt/video/(mount name) -p (host port for webui):80 --rm -d louna  
  example : docker run -v /home/ogaland/samba/video:/mnt/video/mount1 -p 8080:80 --rm -d louna
- Open web browser on host ip with host port, check parameters (profile and optional tag to append on converted video file name) and start Louna<br/>
  example : http://192.168.12.5:8080

Notes :
- If you want to monitor several directories, use -v option several time to mount each host directory with a different mount name

Technical stuff :
- Docker image implement ubuntu with apache/php services for webui, and ffmpeg for video conversion.
- ffmpeg is rebuilt and compiled with x265 support when creating docker image (Louna was designed at first to do x265 conversion)
- If you want to add others transcode profile, you can check src/python/profiles directory and add another xml with the audio and video codec/options you want (see ffmpeg doc)






