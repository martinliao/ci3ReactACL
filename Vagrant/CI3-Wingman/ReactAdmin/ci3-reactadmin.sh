#!/bin/bash

set -ex

PROJECTID='reactadmin'

cd /var/www/html
git clone https://github.com/oxygenfox/reactadmin.git
#cp -r reactadmin /var/www/html/
sudo chown -R vagrant: /var/www/html/reactadmin

mysql -uroot -pjack5899 -e "Create Database IF NOT EXISTS ${PROJECTID} CHARACTER SET utf8mb4 Collate utf8mb4_unicode_ci;"

mysql -uroot -pjack5899 ${PROJECTID} < /vagrant/CI3-Wingman/reactadmin/database.sql

cp /vagrant/CI3-Wingman/reactadmin/database.php ${DOCROOT}/application/config/
cp /vagrant/CI3-Wingman/reactadmin/database.php /var/www/html/reactadmin/application/config/

## Fix Bug
mv ${DOCROOT}/application/modules/home/views/Index.php ${DOCROOT}/application/modules/home/views/index.php
mv ${DOCROOT}/application/views/_layout/Auth ${DOCROOT}/application/views/_layout/auth
mv ${DOCROOT}/application/views/_layout/Admin ${DOCROOT}/application/views/_layout/admin

#password#$2y$10$1LfJVrr1ItplFlCGiVWpgepuhLDmvkhWBrl7PzTiEDWdpmnQzN5Wy
#123456#$2y$10$4IPLOB4CrQkgNOhDGDeIc.yUYLpnCypmegplvsQKa.RoMgRQhVD9e

sudo chown -R vagrant: /var/www/html/reactadmin

echo "*** Plear login via admin/1232456"
echo "*** reactadmin is done."