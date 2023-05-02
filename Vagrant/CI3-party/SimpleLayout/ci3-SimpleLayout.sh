#!/bin/bash

#set -ex

cd ~/SimpleLayout
cp libraries/Layout.php ${DOCROOT}/application/libraries/
cp config/layout.php ${DOCROOT}/application/config/
cp -r public ${DOCROOT}/
cp -r views/AdminLTE ${DOCROOT}/application/views/
echo "array_push(\$autoload['libraries'], 'layout');" | tee -a ${DOCROOT}/application/config/autoload.php
cp controller.php ${DOCROOT}/application/controllers/User.php

# 去掉 demo.js 內的 ga
cd ${DOCROOT}/public/themes/AdminLTE/dist/js
sed -i "/[ ]*ga[(].*/d" demo.js

sudo chown -R ${sshUsername}:www-data ${DOCROOT}

echo "*** SimpleLayout is done"