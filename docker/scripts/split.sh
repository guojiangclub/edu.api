#!/bin/bash
#
HEADS="master"
TAGS="v2.0.0"

split()
{
    SUBDIR=./.split/$1
    SPLIT=$2

    mkdir -p $SUBDIR;

    pushd $SUBDIR;

    for HEAD in $HEADS
    do

        mkdir -p $HEAD

        pushd $HEAD

        git subsplit init git@gitee.com:zidaibudai/ibrand-admin.git
        git subsplit update

        time git subsplit publish --heads="$3" "$SPLIT" --tags=$4

        popd

    done

    popd

    rm -rf ./.split
}

split address  src/modules/Component/Address:git@gitee.com:zidaibudai/Address.git $HEADS $TAGS
split advertisement  src/modules/Component/Advertisement:git@gitee.com:zidaibudai/Advertisement.git $HEADS $TAGS
split balance  src/modules/Component/Balance:git@gitee.com:zidaibudai/Balance.git $HEADS $TAGS
split BankAccount src/modules/Component/BankAccount:git@gitee.com:zidaibudai/BankAccount.git $HEADS $TAGS
split Brand  src/modules/Component/Brand:git@gitee.com:zidaibudai/Brand.git $HEADS $TAGS
split Bundle  src/modules/Component/Bundle:git@gitee.com:zidaibudai/Bundle.git $HEADS $TAGS
split Card  src/modules/Component/Card:git@gitee.com:zidaibudai/Card.git $HEADS $TAGS
split Category  src/modules/Component/Category:git@gitee.com:zidaibudai/Category.git $HEADS $TAGS
split channel  src/modules/Component/channel:git@gitee.com:zidaibudai/channel.git $HEADS $TAGS
split Discount  src/modules/Component/Discount:git@gitee.com:zidaibudai/Discount.git $HEADS $TAGS
split Favorite  src/modules/Component/Favorite:git@gitee.com:zidaibudai/Favorite.git $HEADS $TAGS
split Grade  src/modules/Component/Grade:git@gitee.com:zidaibudai/Grade.git $HEADS $TAGS
split Invoice  src/modules/Component/Invoice:git@gitee.com:zidaibudai/Invoice.git $HEADS $TAGS
split Marketing  src/modules/Component/Marketing:git@gitee.com:zidaibudai/Marketing.git $HEADS $TAGS
split Order  src/modules/Component/Order:git@gitee.com:zidaibudai/Order.git $HEADS $TAGS
split Payment  src/modules/Component/Payment:git@gitee.com:zidaibudai/Payment.git $HEADS $TAGS
split Point  src/modules/Component/Point:git@gitee.com:zidaibudai/Point.git $HEADS $TAGS
split Product  src/modules/Component/Product:git@gitee.com:zidaibudai/Product.git $HEADS $TAGS
split Refund  src/modules/Component/Refund:git@gitee.com:zidaibudai/Refund.git $HEADS $TAGS
split Registration  src/modules/Component/Registration:git@gitee.com:zidaibudai/Registration.git $HEADS $TAGS
split Scheduling  src/modules/Component/Scheduling:git@gitee.com:zidaibudai/Scheduling.git $HEADS $TAGS
split Setting  src/modules/Component/Setting:git@gitee.com:zidaibudai/Setting.git $HEADS $TAGS
split Shipping  src/modules/Component/Shipping:git@gitee.com:zidaibudai/Shipping.git $HEADS $TAGS
split User  src/modules/Component/User:git@gitee.com:zidaibudai/User.git $HEADS $TAGS
split suit  src/modules/Component/suit:git@gitee.com:zidaibudai/suit.git $HEADS $TAGS
split activity-core  src/modules/Activity/Admin:git@gitee.com:zidaibudai/activity-core.git $HEADS $TAGS
split activity-server  src/modules/Activity/Server:git@gitee.com:zidaibudai/activity-server.git $HEADS $TAGS
split activity-admin  src/modules/Activity/Core:git@gitee.com:zidaibudai/activity-admin.git $HEADS $TAGS
split album-backend  src/modules/AlbumBackend:git@gitee.com:zidaibudai/album-backend.git $HEADS $TAGS
split backend  src/modules/Backend:git@gitee.com:zidaibudai/Backend.git $HEADS $TAGS
split cms  src/modules/Cms:git@gitee.com:zidaibudai/Cms.git $HEADS $TAGS
split distribution-core  src/modules/Distribution/Core:git@gitee.com:zidaibudai/distribution-core.git $HEADS $TAGS
split distribution-server  src/modules/Distribution/Server:git@gitee.com:zidaibudai/distribution-server.git $HEADS $TAGS
split distribution-backend  src/modules/Distribution/Backend:git@gitee.com:zidaibudai/distribution-backend.git $HEADS $TAGS
split member-backend  src/modules/Member/Backend:git@gitee.com:zidaibudai/member-backend.git $HEADS $TAGS
split server  src/modules/Server:git@gitee.com:zidaibudai/server.git $HEADS $TAGS
split shop-backend  src/modules/Shop/Backend:git@gitee.com:zidaibudai/shop-backend.git $HEADS $TAGS
split store-backend  src/modules/Store/Backend:git@gitee.com:zidaibudai/store-backend.git $HEADS $TAGS
split store-frontend  src/modules/Store/Frontend:git@gitee.com:zidaibudai/joyoutdoor-store.git $HEADS $TAGS
split store-contenthub  src/modules/Store/ContentHub:git@gitee.com:zidaibudai/content-hub-pc.git $HEADS $TAGS
split wechat-backend  src/modules/Wechat/Backend:git@gitee.com:zidaibudai/wechat-backend.git $HEADS $TAGS
split wechat-server  src/modules/Wechat/Server:git@gitee.com:zidaibudai/wechat-server.git $HEADS $TAGS