#!/bin/bash

#set -ex

cd ~/CRUD
## 1. 覆蓋新的 Layout
cp Layout.php ${DOCROOT}/application/libraries/

## 2. 第2個佈景 CRUD
cp -r public/themes/CRUD ${DOCROOT}/public/themes/
cp -r public/common ${DOCROOT}/public/
cp -r views/CRUD ${DOCROOT}/application/views/

## 3. Add Customers(加 Customers 模組)
cp -r modules/Customers ${DOCROOT}/application/modules/

## 4. 加路由.
cat <<EOF | tee -a ${DOCROOT}/application/config/routes.php
// Customers
\$route['customerListing'] = 'customers/customerListing';
EOF

## 5. Import customer
mysql -uroot -pjack5899 ${PROJECTID} < DB/customers.sql

## 6. 改 layout
sed -i "s/\(.*config\['theme'\][ ]\).*/\1= 'CRUD';/g" ${DOCROOT}/application/config/layout.php
sed -i "s/\(.*config\['layout'\][ ]\).*/\1= 'layout';/g" ${DOCROOT}/application/config/layout.php

sudo chown -R ${sshUsername}:www-data ${DOCROOT}

echo "*** CRUD is done"