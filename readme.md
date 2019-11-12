# 果酱学院

果酱学院是为专业教培机构和个人提供的支持在线教育服务的平台系统。

目前只提供移动端 H5，不包含小程序，PC和APP.

## 体验

![果酱学院](https://iyoyo.oss-cn-hangzhou.aliyuncs.com/post/miniprogramcode/edu.qrcode.png)

## 安装

```
git clone git@gitlab.guojiang.club:guojiangclub/edu.api.git

composer install -vvv

cp .env.example .env    # 务必配置好数据库信息

php artisan vendor:publish --all

chmod -R 0777 storage

chmod -R 0777 bootstrap
 
php artisan ibrand:edu-install
```

## H5

源码地址：[果酱学院H5源码](http://gitlab.guojiang.club:8090/guojiangclub/edu.h5)