#!/bin/bash

set -ex

if [ -d '/var/www/html/reactadmin' ]; then
    SOURCEDIR='/var/www/html/reactadmin'
else
    cd ~/
    git clone https://github.com/oxygenfox/reactadmin.git
    SOURCEDIR=$(PWD)/reactadmin
fi

cd $SOURCEDIR
cp application/libraries/MY_Form_validation.php ${DOCROOT}/application/libraries/
cp application/helpers/assets_helper.php ${DOCROOT}/application/helpers/
#cp application/helpers/react_helper.php ${DOCROOT}/application/helpers/ # 2May2023, 不需要了, 改用 render_page
# 加 modules
cp -r application/modules/home ${DOCROOT}/application/modules/
#cp -r application/modules/auth ${DOCROOT}/application/modules/

#   修 bug
if [ -f ${DOCROOT}/application/modules/home/views/Index.php ]; then
    mv ${DOCROOT}/application/modules/home/views/Index.php ${DOCROOT}/application/modules/home/views/index.php # Fix bug
fi

# 加 view, assets
cp -r assets ${DOCROOT}/
cp -r application/views/_layout ${DOCROOT}/application/views/_reactadmin
mkdir -p ${DOCROOT}/application/views/_layout/general
cp -r application/views/_layout/admin/head.php ${DOCROOT}/application/views/_layout/general/

##      1. 修改 config
cd ${DOCROOT}/application/config
##      1-a. 在 base_url 後加 PATH_ASSETS
sed -i "/.*config\['base_url'\][ ]=[ ].*;/a define('PATH_ASSETS', \$config['base_url'] . '/assets/');" config.php
##      1-b. 確認有開 hook, 因為需要 DevelBar 幫忙除錯.
sed -i "s/.*config\['enable_hooks'\].*/\$config\[\'enable_hooks\'\] = TRUE;/g" config.php
##      1-c. 加 modules_locations => admin_tools
echo "\$config['modules_locations'] = array_merge(array(APPPATH.'admin_tools/' => '../admin_tools/'), \$config['modules_locations']);" | tee -a config.php

##      2. 修改 常數 constants
echo "define('APP_NAME', 'Click-React');" | tee -a constants.php

##      3. 修改 預設 路由
sed -i "s/\(.*route\['default_controller'\][ ]\).*/\1= 'home';/g" routes.php

##      4. 改 autoload.php
##      4-a. Library 加 form_validation
echo "array_push(\$autoload['libraries'], 'form_validation');" | tee -a autoload.php
##      4-b. Helper 加 file, form, rect_helper, assets_helper
echo "array_push(\$autoload['helper'], 'file');" | tee -a autoload.php
echo "array_push(\$autoload['helper'], 'form');" | tee -a autoload.php
#echo "array_push(\$autoload['helper'], 'react_helper');" | tee -a autoload.php # 2May2023, 不需要了, 改用 render_page
echo "array_push(\$autoload['helper'], 'assets_helper');" | tee -a autoload.php

##      5. Controller 修改
cd /vagrant/CI3-party/ReactJquery/
##      5-a. 加 Admin Controller
cp core/Admin_Controller.php ${DOCROOT}/application/core/
##      5-a. 在 My_Controller 加入 Admin_Controller.php 引用.
cat <<EOF | tee -a ${DOCROOT}/application/core/MY_Controller.php

// Admin controller
require_once(APPPATH.'core/Admin_Controller.php');
EOF

##      6. 覆蓋 MY_Controll, 加 hmvc_fixes()
cp core/MY_Controller.php ${DOCROOT}/application/core/

##      7. 加 admin tools (管理工具)
mkdir -p ${DOCROOT}/application/admin_tools
cp -r admin_tools/{access,Admin,menu,submenu,page,role,user} ${DOCROOT}/application/admin_tools/

##      8. Migrations (升級)
cp migrations/002_Create_Demo.php ${DOCROOT}/application/migrations/
cp migrations/003_Menu_Preferences.php ${DOCROOT}/application/migrations/
cp migrations/004_Demo_Manager.php ${DOCROOT}/application/migrations/

###     9. 修 _layout
cp -r views/_reactadmin/admin/*  ${DOCROOT}/application/views/_reactadmin/admin/
##      10-b. 因為 ss_settings 改成 array, 所以 $ss_settings->xxx 要換成 $ss_settings['xxx']
sed -i "s/\(\$ss_settings\)->\([a-z_]*\)/\$ss_settings['\2']/g" ${DOCROOT}/application/views/_reactadmin/admin/footer.php
sed -i "s/\(\$ss_settings\)->\([a-z_]*\)/\$ss_settings['\2']/g" ${DOCROOT}/application/views/_reactadmin/admin/sidebar.php

###     10. 路由 Route (去 SmartACL-moduels, 改用 React) 及 加 redis
#cp config/{config,routes}.php ${DOCROOT}/application/config/
cp config/{redis,routes}.php ${DOCROOT}/application/config/

###     11. 改 unauthorized_route 為 page (From 'unauthorized')
sed -i "s/\(.*config\['unauthorized_route'\][ ]\).*/\1= 'page';/g" ${DOCROOT}/application/third_party/SmartyAcl/config/smarty_acl.php
###     12. 改 cache_settings - driver 為 redis
echo "\$config['cache_settings']['driver'] = 'redis';" | tee -a ${DOCROOT}/application/third_party/SmartyAcl/config/smarty_acl.php
###     13. 因為 SmartACL 改為 Admins (From Admin)
cp views/header.php ${DOCROOT}/application/views/

echo "*** Yout can go to: http://localhost/${PROJECTID}/welcome/importdatabase to migrate database!"
echo "*** React is done."