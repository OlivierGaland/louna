FROM ubuntu:18.04
MAINTAINER Olivier Galand "galand.olivier.david@gmail.com"

#Install and compile ffmpeg with x265 support
RUN apt-get update -qq && \
    apt-get --no-install-recommends -y install \
	autoconf \
	automake \
	build-essential \
    ca-certificates \
	cmake \
	git \
	libass-dev \
	libfreetype6-dev \
	libtheora-dev \
	libtool \
	libvorbis-dev \
	mercurial \
	pkg-config \
	texinfo \
	wget \
	zlib1g-dev \
	yasm \
	libx264-dev \
	libvpx-dev \
	libfdk-aac-dev \
	libmp3lame-dev \
	libopus-dev && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /tmp/src
RUN hg clone https://bitbucket.org/multicoreware/x265
WORKDIR x265/build/linux
RUN PATH="$HOME/bin:$PATH" cmake -G "Unix Makefiles" -DCMAKE_INSTALL_PREFIX="/usr/local/" -DENABLE_SHARED:bool=off ../../source && \
    PATH="$HOME/bin:$PATH" make && \
    make install

WORKDIR /tmp/src
RUN wget -O ffmpeg-snapshot.tar.bz2 https://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2 && \
    tar xjvf ffmpeg-snapshot.tar.bz2

WORKDIR ffmpeg
RUN PATH="$HOME/bin:$PATH" PKG_CONFIG_PATH="/usr/local/lib/pkgconfig" ./configure \
        --prefix="/usr/local" \
        --pkg-config-flags="--static" \
        --extra-cflags="-I/usr/local/include" \
        --extra-ldflags="-L/usr/local/lib" \
        --extra-libs="-lpthread -lm" \
        --bindir="/usr/local/bin" \
        --enable-gpl \
        --enable-libass \
        --enable-libfdk-aac \
        --enable-libfreetype \
        --enable-libmp3lame \
        --enable-libopus \
        --enable-libtheora \
        --enable-libvorbis \
        --enable-libvpx \
        --enable-libx264 \
        --enable-libx265 \
        --enable-nonfree && \
    make && make install && hash -r

WORKDIR /
RUN rm -rf /tmp/src

#Apache configuration
RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install \
        apache2 php7.2 libapache2-mod-php7.2 php7.2-xml && \
    rm -rf /var/lib/apt/lists/*

RUN a2enmod php7.2
RUN a2enmod rewrite

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

ADD src /var/www/site
ADD cnf/apache-config.conf /etc/apache2/sites-enabled/000-default.conf

RUN chown -R www-data:www-data /var/www
RUN chmod u+s /usr/bin/python3 /usr/local/bin/ffmpeg /var/www/site/shell/kill_louna.sh

CMD /usr/sbin/apache2ctl -D FOREGROUND
