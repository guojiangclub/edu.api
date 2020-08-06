#!/usr/bin/env bash

set -ex

cd $DOCUMENT_ROOT/

# 生成APP_KEY
php artisan key:generate

# 安装数据库
php artisan migrate --force

# 生成后台 admin@admin.com 123456 账号
php artisan backend:admin

# 初始化基础配置信息
php artisan backend:setting

# 其他一些初始化
php artisan el_goods_spec:factory
php artisan bankAccount:factory

# 生成API密钥
php artisan passport:install

# 设置权限
chmod -R 777 storage/