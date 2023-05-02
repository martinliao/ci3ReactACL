#!/bin/bash

#set -ex
#  加 Mobile 的偵測, 在 RWD(bootstrap) 應該是不用, Apr2023.

## Add Mobile detect library
cd ~/
##cp /CI3/thirdparty/Mobile-Detect/MobileDetect-3.74.php ${DOCROOT}/application/libraries/common
##wget -qnv https://raw.githubusercontent.com/serbanghita/Mobile-Detect/3.74.x/src/MobileDetect.php -O ${DOCROOT}/application/libraries/common # 新版有PHP問題...
wget -qnv https://github.com/serbanghita/Mobile-Detect/archive/refs/tags/2.8.41.zip
unzip 2.8.41.zip > /dev/null 2>&1
mv Mobile-Detect* Mobile-Detect
mkdir -p ${DOCROOT}/application/libraries/common
cp Mobile-Detect/Mobile_Detect.php ${DOCROOT}/application/libraries/common/

# $autoload['libraries'] = array('form_validation', 'ion_auth', 'template', 'common/mobile_detect');
#echo "array_push(\$autoload['libraries'], 'common/mobile_detect');" | tee -a ${DOCROOT}/application/config/autoload.php # 舊版from CI_LTE
echo "array_push(\$autoload['libraries'], 'common/Mobile_Detect');" | tee -a ${DOCROOT}/application/config/autoload.php

#ref: https://github.com/serbanghita/Mobile-Detect

echo "*** Add Mobile-Detect is done"
