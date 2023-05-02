#!/bin/bash

set -ex

<<comment
## 0. 先把 base_url 清空
sed -i "s/\(.*config\['base_url'\][ ]\).*/\1= '';/g" ${DOCROOT}/application/config/config.php
cd ${DOCROOT}/application/config
sed -i "/.*config\['base_url'\] = '';/a\$config['base_url'] = rtrim(\$base, '/');" config.php
sed -i "/.*config\['base_url'\] = '';/a\$base .= str_replace(basename(\$_SERVER['SCRIPT_NAME']),\"\",\$_SERVER['SCRIPT_NAME']);" config.php
sed -i "/.*config\['base_url'\] = '';/a\$base  = \"http://\".\$_SERVER['HTTP_HOST'];" config.php
comment

## 0. 加 core, 因為 codeignitor-requirejs-backbone 的 core/MY_Controller 是繼承自 CI_Controller, 所以要改(從core_MX).
cp ~/CI3-RequireJS/core_MX/* ${DOCROOT}/application/core/

## 1. 加 controllers
cp ~/CI3-RequireJS/controllers/General.php ${DOCROOT}/application/controllers/
cp -r ~/CI3-RequireJS/controllers/api ${DOCROOT}/application/controllers/

## 2. 加 models
cp ~/CI3-RequireJS/models/Api_model.php ${DOCROOT}/application/models/

## 3. 加 views
#cp ~/CI3-RequireJS/views/templates/header.php ${DOCROOT}/application/views/templates/header.php
cp -r ~/CI3-RequireJS/views/layout ${DOCROOT}/application/views/
cp -r ~/CI3-RequireJS/views/templates ${DOCROOT}/application/views/
cp -r ~/CI3-RequireJS/views/example ${DOCROOT}/application/views/
cp -r ~/CI3-RequireJS/views/general ${DOCROOT}/application/views/

## 4. 處理 Theme 及 Layout
##   4-a. 加 Theme(library)
cp ~/CI3-RequireJS/libraries/Theme.php ${DOCROOT}/application/libraries/
#echo "array_push(\$autoload['libraries'], 'theme');" | tee -a ${DOCROOT}/application/config/autoload.php # 預設不用載入.

##   4-b. 加 Layout(hooks)
cp ~/CI3-RequireJS/hooks/Layout.php ${DOCROOT}/application/hooks/
sed -i "s/\(.*config\['enable_hooks'\][ ]\).*/\1= TRUE;/g" ${DOCROOT}/application/config/config.php

if [ '${HOOKLAYOUT}' == 'true' ]; then
cat <<EOF | tee -a ${DOCROOT}/application/config/hooks.php
\$hook['display_override'] = array(
    'class'    => 'Layout',
    'function' 	=> 'index',
    'filename' => 'Layout.php',
    'filepath' => 'hooks'
);
EOF
fi

cd ~/CI3-RequireJS/
##   4-c. config Theme設定檔(預設 Theme)
cp config/theme.php ${DOCROOT}/application/config/
##   4-d. 覆改 FrontendController 使用 Theme (load->library('theme'))
cp core_MX/Frontend_Controller.php ${DOCROOT}/application/core/


## 5. 加路由
cat <<EOF | tee -a ${DOCROOT}/application/config/routes.php
// Custom Routes
\$route['/'] = 'general/index';

// Ajax API routes
\$route['api'] = 'api/ajax/index';
\$route['api/get?(:any)'] = 'api/ajax/get/\$1';
\$route['api/post'] = 'api/ajax/post';

// Catch all default for direct access to controllers
\$route['(:any)/(:any)'] = '\$1/\$2';
EOF

## 6. 複製 assets (css 及 js)
cp ~/CI3-RequireJS/assets/favicon.ico ${DOCROOT}/
cp -r ~/CI3-RequireJS/assets/js ${DOCROOT}/
cp -r ~/CI3-RequireJS/assets/css ${DOCROOT}/

sudo chown -R ${sshUsername}:www-data ${DOCROOT}

#http://localhost/codeignitor-requirejs-backbone/javascript/1681467711/lib/javascript-static.js
echo "*** RequireJS for ci3 is done."