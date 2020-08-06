#!/usr/bin/env bash

set -ex

cd $DOCUMENT_ROOT/

# 检查配置文件
if [ "`cat .env | grep 'APP_UPDATE=true' `" != "" ]; then
    # 更新数据库
    php artisan migrate --force

    php artisan view:clear
else
    # 生成APP_KEY
    php artisan key:generate
    # 安装数据库
    php artisan migrate --force
    # 安装商城
    # php artisan ibrand:store-install --force
    # 生成API密钥
    php artisan passport:install
    # 设置权限
    chmod -R 777 storage/
    # 安装成功
    setEnv .env APP_UPDATE true
fi