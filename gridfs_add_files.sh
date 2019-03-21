#!/usr/bin/env bash

images=`ls -U ./images/`

for image in $images; do
  mongofiles \
    --host=localhost \
    --port=27017 \
    --db=haunted \
    put ${image%%.*} --local ./images/$image
done
