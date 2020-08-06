#!/usr/bin/env bash

# source /root/workspace/scripts/common.sh

# 目录
# SCRIPTS=$(cd `dirname $0`; pwd)
# ROOT=$(dirname ${SCRIPTS})

SCRIPTS=/root/workspace/edu.api/docker/scripts
ROOT=/root/workspace/edu.api


# 登录docker目录
BASE_NAME=registry.cn-hangzhou.aliyuncs.com/guojiangclub/edu.api
sudo docker login -u ${username} -p ${password} registry.cn-hangzhou.aliyuncs.com

# 设置GIT
git config --global user.email "admin@guojiang.club"
git config --global user.name "guojiangclub"