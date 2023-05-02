# Codeigniter Smarty-Acl Demo
Demo application using [SmartyAcl](https://github.com/martinliao/codeigniter-smarty-acl) library for testing and reference.
demo-github: https://github.com/martinliao/codeigniter-smarty-acl-demo

## JK-Memo

admin/123456
記得要點 Admin 登入(不是 User 登入)

## Vagrant

### HMVC 化

Vagrantfile 呼叫, 把 Admin/Auth/AuthAdmin 都轉成 HMVC 了(在 modules 內)

### 產生 Database

利用 CI的Migration , 在 welcome/importdataase 可以在 install 時產生 DB.


### Demo 安裝重點(Installation)

1. git clone from https://github.com/martinliao/codeigniter-smarty-acl-demo

2. 修改 config.php, base_url

    ```
    $config['base_url'] = '';
    ````
    或
    ```
    $base  = "http://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $config['base_url'] = rtrim($base, '/');
    ```

3. 修改 header..php

    把 
    ```
    href="/account
    ```
    改成 
    ```
    href="<?php echo base_url();?>account
    ```
4. 設定 config.php, 建 database

    假設 database 為 codeigniter-smarty-acl-demo, 使用以下 sql 建立 database.
    ```
    mysql -uroot -pjack5899 -e 'Create Database IF NOT EXISTS `codeigniter-smarty-acl-demo` CHARACTER SET utf8mb4 Collate utf8mb4_unicode_ci;'
    ```
    並且設定好 database.php !!

5. 使用 migration (升級), 自動建立 demo 內容.

    http://localhost/xxx/importdatabase

    就可以用 admin/12345 在 Admin 登入了.

6. 如果是 Apache(Nginx不用處理), 處理 AllowOverride(.htaccess)

    ```
    cat <<EOF | sudo tee /etc/httpd/conf.d/codeigniter-smarty-acl-demo.conf
    <Directory "/var/www/html/codeigniter-smarty-acl-demo">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    EOF
    ```

    sudo systemctl restart httpd

    並確定 /.htaccess 內容如下: 
    ```
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
    ```

    done.

### Feature特徵

* 使用 SmartyACL, 有 config, 相對只檢查 session; 它有 config 可彈性設定
* SmartyACL: PHP7 or above
* 支援多國語言
* 它有 Email templates, eg. activate或忘記密碼的 template(也支援多國語言).
* config 設定很豐富.
* Docs 文件寫的很清楚.
* ACL 有 角色對Module 可交叉權限(permission).

### Auth VS. AuthAdmin

它有兩個 Auth, Auth 是一般 User, AuthAdmin 是 Admin 專用, 不要用錯了.

### What's included
- [Codeigniter](https://codeigniter.com/) 3.1.11
- [SmartyAcl Library](https://github.com/rubensrocha/codeigniter-smarty-acl) 1.0
- [Codeigniter Developer Toolbar](https://github.com/JCSama/CodeIgniter-develbar/) 3

### Installation
1. Download latest released version
2. Configure your database settings on `application/config/database.php`
3. Configure your base_url on `application/config/config.php`
4. Open `yoursite.com/importdatabase` to run database migrations

### Default Admin
Username: admin<br>
Password: 123456
