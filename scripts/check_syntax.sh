#!/bin/bash

echo "Testing syntax files"

for file in $(find ./ -path -prune -o -type f -name "*.php"); do
    eval "php -l ${file}"
    ret_code=$?

    if [ ${ret_code} != 0 ]; then exit ${ret_code}
  fi
done

# find . -name \*.php -exec php -l "{}" \;