#!/usr/bin/env bash

set -ex

cd $DOCUMENT_ROOT/

# 链接OSS目录
if [ ! -L storage/app ]; then
   ln -sf $DATA_FILES/app storage/app
fi

# 设置env
setEnv .env APP_URL $APP_URL
setEnv .env APP_NAME $APP_NAME
setEnv .env DB_HOST $DB_HOST
setEnv .env DB_DATABASE $DB_DATABASE
setEnv .env DB_USERNAME $DB_USERNAME
setEnv .env DB_PASSWORD $DB_PASSWORD
setEnv .env REDIS_HOST $REDIS_HOST
setEnv .env REDIS_PASSWORD $REDIS_PASSWORD

