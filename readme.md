## 果酱学院

果酱学院是为专业教培机构和个人提供的支持在线教育服务的平台系统。

目前只提供移动端 H5，不包含小程序，PC和APP.

## 效果截图

![果酱学院](https://cdn.guojiang.club/edu1012.jpg)

## 功能列表

- 课程管理（支持音、视频、图文）
- 订单管理
- 学员管理
- 促销活动
- 在线试看
- 在线支付


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

源码地址：[果酱学院H5源码](https://gitee.com/guojiangclub/edu.h5)


## 交流

扫码添加[玖玖|彼得助理]，可获得“陈彼得”为大家精心整理的程序员成长学习路线图，以及前端、Java、Linux、Python等编程学习资料，同时还教你25个副业赚钱思维。

![玖玖|彼得助理 微信二维码](https://cdn.guojiang.club/xiaojunjunqyewx2.jpg)