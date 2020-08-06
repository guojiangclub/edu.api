FROM registry.cn-hangzhou.aliyuncs.com/guojiangclub/php:7.2

# 环境变量
ENV DOCUMENT_PUBLIC /data/www/public/public

# 复制源码
COPY ./ $DOCUMENT_ROOT

RUN set -ex \
    # 设置目录权限
    && chmod -R 777 bootstrap/cache storage \
    # 安装模块
    && composer install -vvv \
    # 生成模块相关文件
    && php artisan vendor:publish --all

RUN set -ex \
    && ln -s $DATA_FILES/app/public public/storage \
    && ln -s $DATA_FILES/app/uploads public/uploads \
    # storage
    && rm -rf storage \
    && ln -s $DATA_SHARE/storage storage \

    # migrations
    # && rm -rf database/migrations \
    # && ln -s $DATA_SHARE/migrations database/migrations \

    && ln -s $DATA_SHARE/env .env

COPY docker/opt /opt
COPY docker/etc /etc

RUN set -ex \
    && chmod -R +x /opt/scripts

# 按容器应用不同
# ENV APP_URL "//localhost"
# ENV DB_DATABASE ""

# 按容器集群不同
# ENV DB_USERNAME ""
# ENV DB_PASSWORD ""
# ENV REDIS_PASSWORD null
