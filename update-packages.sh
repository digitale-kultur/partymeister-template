#!/usr/bin/env bash
for i in `ls packages/`; do cd packages/$i; git checkout evoke2023; git pull; cd ..; cd ..; done
