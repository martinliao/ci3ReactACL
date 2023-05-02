#!/bin/bash

#echo $PROJECTID
#echo $DOCROOT

cat <<EOF | sudo tee /etc/httpd/conf.d/${PROJECTID}.conf
<Directory "${DOCROOT}">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
EOF

cat <<EOF | sudo tee ${DOCROOT}/.htaccess
DirectoryIndex index.php
RewriteEngine on
RewriteCond \$1 !^(index\.php|images|css|js|robots\.txt|favicon\.ico)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)\$ ./index.php/\$1 [L,QSA]
EOF