#!/bin/bash

# 在 nginx, 因為沒有 .htaccess 的 rewrite, 在網址列會多了 index.php.(在網址要去掉index.php).
# $config['index_page'] = '';

cd ${DOCROOT}/application/config
sed -i "s/\(.*config\['index_page'\][ ]\).*/\1= '';/g" config.php

echo "*** done"