#!/bin/sh

for p in `ps -aux | grep ffmpeg | grep -v grep | awk '{ print $2 }'`; do kill -9 $p ; done
for p in `ps -aux | grep transcode | grep -v grep | awk '{ print $2 }'`; do kill -9 $p ; done
