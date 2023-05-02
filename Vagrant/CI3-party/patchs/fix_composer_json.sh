#!/bin/bash

# 從 codeigniter 3 check-out出來的 composer.json 有誤.

if [ -f '${DOCROOT}/composer.json' ]; then
    ## 1. 修 mikey179/vfsstream 大寫問題.
    sed -i "s|mikey179/vfsStream|mikey179/vfsstream|g" ${DOCROOT}/composer.json

    rm -f composer.lock
    composer install
fi

echo "*** composer.json fix is done"
