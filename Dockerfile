FROM php:apache
MAINTAINER Olivier Galand "galand.olivier.david@gmail.com"

RUN apt-get update && apt-get upgrade -y && apt-get install -y ffmpeg python3

COPY src/ /var/www/html/

#RUN chown -R www-data:www-data /var/www
#RUN chmod u+s /usr/bin/python3 /usr/local/bin/ffmpeg /var/www/html/shell/kill_louna.sh

#CMD /usr/sbin/apache2ctl -D FOREGROUND
