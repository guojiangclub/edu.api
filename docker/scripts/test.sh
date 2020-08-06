#!/usr/bin/env bash

set -ex
source ./common.sh

cd ${ROOT}/src

# 测试
composer install
./vendor/bin/phpunit

git clean -xfd

cd ${SCRIPTS}