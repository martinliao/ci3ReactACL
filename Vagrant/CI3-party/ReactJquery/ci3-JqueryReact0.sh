#!/bin/bash

set -ex

if [ -d '/var/www/html/reactadmin' ]; then
    cd /var/www/html
else
    cd ~/
    git clone https://github.com/oxygenfox/reactadmin.git
fi

cd reactadmin
cp application/libraries/MY_Form_validation.php ${DOCROOT}/application/libraries/
cp application/helpers/assets_helper.php ${DOCROOT}/application/helpers/
cp application/helpers/react_helper.php ${DOCROOT}/application/helpers/
# 加 modules
cp -r application/modules/home ${DOCROOT}/application/modules/
cp -r application/modules/menu ${DOCROOT}/application/modules/
#cp -r application/modules/auth ${DOCROOT}/application/modules/
#cp -r application/modules/admin ${DOCROOT}/application/modules/

# 加 view
cp -r assets ${DOCROOT}/
cp -r application/views/_layout ${DOCROOT}/application/views/


##      1. 修改 config
##      1-a. 在 base_url 後加 PATH_ASSETS
#sed -i "/.*config\['base_url'\][ ]= '';.*/d" ${DOCROOT}/application/config/config.php # 砍空的 base_url.
sed -i "/.*config\['base_url'\][ ]=[ ].*;/a define('PATH_ASSETS', \$config['base_url'] . '/assets/');" ${DOCROOT}/application/config/config.php

##      1-b. 加常數
echo "define('APP_NAME', 'Click-React');" | tee -a ${DOCROOT}/application/config/constants.php

##      1-c. 修改 預設 路由
sed -i "s/\(.*route\['default_controller'\][ ]\).*/\1= 'home';/g" ${DOCROOT}/application/config/routes.php

##      2. Add Library
echo "array_push(\$autoload['libraries'], 'form_validation');" | tee -a ${DOCROOT}/application/config/autoload.php

##      3. Add Helper
echo "array_push(\$autoload['helper'], 'file');" | tee -a ${DOCROOT}/application/config/autoload.php
echo "array_push(\$autoload['helper'], 'form');" | tee -a ${DOCROOT}/application/config/autoload.php
echo "array_push(\$autoload['helper'], 'react_helper');" | tee -a ${DOCROOT}/application/config/autoload.php
echo "array_push(\$autoload['helper'], 'assets_helper');" | tee -a ${DOCROOT}/application/config/autoload.php

<<comment
##      5. 修改 MY_Controll, 加 hmvc_fixes()
cd $DOCROOT/application/core
sed -i "/.*parent::__construct();.*/a \$this->_hmvc_fixes();" MY_Controller.php
##      5-b. 刪最後的 } 
tac MY_Controller.php | sed '0,/}/s///' | tac
##      5-b. 加 
cat /vagrant/CI3-party/ReactJquery/_hmvc_fixes.php | tee -a MY_Controller.php
##      5-c. 把 } 加回去
echo "}" | tee -a MY_Controller.php
comment
##      5. 修改 MY_Controll, 加 hmvc_fixes()
cp /vagrant/CI3-party/ReactJquery/MY_Controller.php ${DOCROOT}/application/core/

##      6. 修 bug
if [ -f ${DOCROOT}/application/modules/home/views/Index.php ]; then
    mv ${DOCROOT}/application/modules/home/views/Index.php ${DOCROOT}/application/modules/home/views/index.php # Fix bug
fi

cd /vagrant/CI3-party/ReactJquery
##      7. Admin_Controller
##      7-1. 加 Admin Controller
cp core/Admin_Controller.php ${DOCROOT}/application/core/
cat <<EOF | tee -a ${DOCROOT}/application/core/MY_Controller.php
// Admin controller
require_once(APPPATH.'core/Admin_Controller.php');
EOF
##      7-2. 補 Admin, overwrite Admin
cp -r admin_tools/Admin/* ${DOCROOT}/application/modules/Admin/

##      8. Migrations
cp migrations/002_Menu_Preferences.php ${DOCROOT}/application/migrations/

##      9. helpers, admin 改名 react_admin
#cp -r helpers/* ${DOCROOT}/application/helpers/

###     10-a. 修 _layout
cp -r views/_layout/admin/*  ${DOCROOT}/application/views/_layout/admin/
##      10-b. 因為 ss_settings 改成 array, 所以 $ss_settings->xxx 要換成 $ss_settings['xxx']
sed -i "s/\(\$ss_settings\)->\([a-z_]*\)/\$ss_settings['\2']/g" ${DOCROOT}/application/views/_layout/admin/footer.php
sed -i "s/\(\$ss_settings\)->\([a-z_]*\)/\$ss_settings['\2']/g" ${DOCROOT}/application/views/_layout/admin/sidebar.php

###     11 加 menu/subment/page
cd /vagrant/CI3-party/ReactJquery
cp -r modules/{menu,submenu,page} ${DOCROOT}/application/modules/

###     13 蓋路由 Route (去 SmartACL-moduels, 改用 React)
cp config/{config,routes}.php ${DOCROOT}/application/config/

echo "*** Yout can go to: http://localhost/${PROJECTID}/welcome/importdatabase to migrate database!"
echo "*** React is done."