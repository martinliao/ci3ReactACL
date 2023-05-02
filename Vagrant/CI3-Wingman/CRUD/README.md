# CRUD

來自於 github: https://github.com/guptarajesh/CodeIgnitor-3.2-Login-Register-Dashboard-CRUD-Operations

## CodeIgnitor 3.2 Login Register Dashboard CRUD Operations

CodeIgnitor 3.2 based CRUD application, used to role based User Login, Registration, Dashboard and CRUD for Manage Customers, Manage Vehicles. Advanced Bootstrap 4.0 based UI for Admin Dashboard (AdminLTE). <br>

### Feature特徵

* isLoggedIn 是用單純的 session 檢查(所以還是要改成 SmartyACL).
* 用 ROLE_ADMIN/ROLE_MANAGER/ROLE_EMPLOYEE (constants) 判斷user角色
* assets 使用 bower 管理

* loadViews 類似 template/layout 的功能, 不同於內建的 load->view() 
* 其它就是 CRUD 的參考, UI 很好.(表頭有 show-entries, search過濾 ), layout 也不錯.

## 客製重點

### SimpleLayout

* 整合進 SimpleLayout, 加入1個名為 CRUD 的 theme; 把include/header.php 及 footer.php 整合進 views/layout.php 內.
    * 它原來是 loadView 分 header/footer(頭/身/底) 的結構.
* DataTable 的 search過濾, 在 views/layout 內, 用 searchBody=='Yes' 來控制.

### 模組化

如果從 CRUD 帶帶過來的功能, 改成 HMVC, 放在 modules 內, 如資料夾所示.

* 例如: Customers, 帶過來的 view 就要把 <div class="content-wrapper"> 拿掉, 否則多了一層.


### Bug?
* isAdmin() 應該是 isAccess? 是判斷有無權限?
* 同上, loadThis() 作用是 Access Denied, 也應該是 loadDenied.

### 安裝 composer

```
curl -Ss https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/composer
```

### 開發準備

```
cd /var/www/html
composer install
```
