# Simple-Layout

ci3-adminlte
Theme 使用 ci3-adminlte(git clone https://github.com/i4mnoon3/ci3-adminlte)

It's a simple themed CodeIgniter 3 with AdminLTE.


## Features特徵

* 用簡單的 Layout 實作佈景(theme), layout在 libraries 內
* Layout 同時有了 theme 及 layout 概念.
    * 使用 $this->layout->view 替代 $this->load->view('index');
    * 使用 $this->layout->set_layout('layout2'); 切換佈景

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
