#!/usr/bin/env bash

set -ex

source ./common.sh

cd ${ROOT}

# 生成新版本
# NEW_VERSION=$(autoVersion beta)

NEW_VERSION="1.0.0"

if [ "${NEW_VERSION}" != "" ]; then
    # 打标签 1.0.*
    git tag -a ${NEW_VERSION} -m "Jenkins" beta
    git push --tags

    # 1.0.*
    sudo docker tag ${BASE_NAME}:beta ${BASE_NAME}:${NEW_VERSION}
    sudo docker push ${BASE_NAME}:${NEW_VERSION}

    # stable
    sudo docker tag ${BASE_NAME}:beta ${BASE_NAME}:stable
    sudo docker push ${BASE_NAME}:stable
fi

cd ${SCRIPTS}
