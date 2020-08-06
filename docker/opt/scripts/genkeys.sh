#!/usr/bin/env bash

set -ex

cd $DOCUMENT_ROOT/

# 生成APP_KEY
php artisan key:generate

# 生成API密钥
php artisan passport:install