#!/usr/bin/env bash

set -ex
source ./common.sh

cd ${ROOT}

# 打标签 beta
 git tag -a beta -m "Jenkins" -f
 git push --tags -f

# latest
sudo docker build --pull -t ${BASE_NAME} .
sudo docker push ${BASE_NAME}

# beta
sudo docker tag ${BASE_NAME} ${BASE_NAME}:beta
sudo docker push ${BASE_NAME}:beta

cd ${SCRIPTS}