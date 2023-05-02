#!/bin/bash

set -ex

## 0. 加 core
cp ~/CI3-JavascriptCtrl/core/MY_Controller.php ${DOCROOT}/application/core/
cp ~/CI3-JavascriptCtrl/core/Javascript_Controller.php ${DOCROOT}/application/core/

## 1. 加 Javascript module (From Moodle29)
cp -r ~/CI3-JavascriptCtrl/helpers/* ${DOCROOT}/application/helpers/
cp -r ~/CI3-JavascriptCtrl/libraries/core ${DOCROOT}/application/libraries/
cp -r ~/CI3-JavascriptCtrl/modules/Javascript ${DOCROOT}/application/modules/

cp -r ~/CI3-JavascriptCtrl/test/lib ${DOCROOT}/application/ # for test

<<comment
# 在 JavascriptController 加入
        \$this->load->helper('configonlylib');
		\$this->load->helper('jslib');
		\$this->load->library(['core/minify']);
comment

sudo chown -R ${sshUsername}:www-data ${DOCROOT}

# http://localhost/ci3rjs/Javascript/1681467711/lib/javascript-static.js
# 注意 Javascript controller 是大寫.
echo "*** Javascript controller for ci3 is done."