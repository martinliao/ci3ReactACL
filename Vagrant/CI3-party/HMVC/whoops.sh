#!/bin/bash

cd ${DOCROOT}
sed -i "/[<?]php/a require_once __DIR__.'\/vendor\/autoload.php';" index.php
sed -i '/.*display_errors.*[ ]1);/a\\t\t$whoops->register();' index.php
sed -i '/.*display_errors.*[ ]1);/a\\t\t$whoops->pushHandler(new Whoops\\Handler\\PrettyPageHandler());' index.php
sed -i '/.*display_errors.*[ ]1);/a\\t\t$whoops = new \\Whoops\\Run;' index.php
sed -i '/.*display_errors.*[ ]1);/a\\t\terror_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);' index.php