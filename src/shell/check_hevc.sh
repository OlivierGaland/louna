#!/bin/sh

CODEC=`ffprobe -v error -select_streams v:0 -show_entries stream=codec_name -of default=noprint_wrappers=1:nokey=1 "$1"`

if [ "$CODEC" = "hevc" ]; then
    exit 1
else
    exit 0
fi
