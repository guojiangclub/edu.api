#!/bin/bash
#
HEADS="master"
TAGS="v2.0.0"

SUBDIR=./.split/ibrand

mkdir -p $SUBDIR;
pushd $SUBDIR;
 
for HEAD in $HEADS
    do

        mkdir -p $HEAD

        pushd $HEAD

        git subsplit init git@gitee.com:zidaibudai/ibrand-admin.git
        git subsplit update

        time git subsplit publish --heads="$HEADS" "
    src/modules/Component/Address:git@gitee.com:zidaibudai/Address.git
    src/modules/Component/Advertisement:git@gitee.com:zidaibudai/Advertisement.git
    src/modules/Component/Balance:git@gitee.com:zidaibudai/Balance.git
	src/modules/Component/BankAccount:git@gitee.com:zidaibudai/BankAccount.git
	src/modules/Component/Brand:git@gitee.com:zidaibudai/Brand.git
	src/modules/Component/Bundle:git@gitee.com:zidaibudai/Bundle.git
	src/modules/Component/Card:git@gitee.com:zidaibudai/Card.git
	src/modules/Component/Category:git@gitee.com:zidaibudai/Category.git
	src/modules/Component/channel:git@gitee.com:zidaibudai/channel.git
	src/modules/Component/Discount:git@gitee.com:zidaibudai/Discount.git
	src/modules/Component/Favorite:git@gitee.com:zidaibudai/Favorite.git
	src/modules/Component/Grade:git@gitee.com:zidaibudai/Grade.git
	src/modules/Component/Invoice:git@gitee.com:zidaibudai/Invoice.git
	src/modules/Component/Marketing:git@gitee.com:zidaibudai/Marketing.git
	src/modules/Component/Order:git@gitee.com:zidaibudai/Order.git
	src/modules/Component/Payment:git@gitee.com:zidaibudai/Payment.git
	src/modules/Component/Point:git@gitee.com:zidaibudai/Point.git
	src/modules/Component/Product:git@gitee.com:zidaibudai/Product.git
	src/modules/Component/Refund:git@gitee.com:zidaibudai/Refund.git
	src/modules/Component/Registration:git@gitee.com:zidaibudai/Registration.git
	src/modules/Component/Scheduling:git@gitee.com:zidaibudai/Scheduling.git
	src/modules/Component/Setting:git@gitee.com:zidaibudai/setting.git
	src/modules/Component/Shipping:git@gitee.com:zidaibudai/Shipping.git
	src/modules/Component/User:git@gitee.com:zidaibudai/User.git
	src/modules/Component/suit:git@gitee.com:zidaibudai/suit.git
	src/modules/Component/Recharge:git@gitee.com:zidaibudai/recharge.git
	src/modules/Component/Gift:git@gitee.com:zidaibudai/gift.git
	src/modules/Notifications:git@gitee.com:zidaibudai/notifications.git
	src/modules/Activity/Admin:git@gitee.com:zidaibudai/activity-core.git
	src/modules/Activity/Server:git@gitee.com:zidaibudai/activity-server.git
	src/modules/Activity/Core:git@gitee.com:zidaibudai/activity-admin.git
	src/modules/AlbumBackend:git@gitee.com:zidaibudai/album-backend.git
	src/modules/Backend:git@gitee.com:zidaibudai/Backend.git
	src/modules/Cms:git@gitee.com:zidaibudai/Cms.git
	src/modules/Distribution/Core:git@gitee.com:zidaibudai/distribution-core.git
	src/modules/Distribution/Server:git@gitee.com:zidaibudai/distribution-server.git
	src/modules/Distribution/Backend:git@gitee.com:zidaibudai/distribution-backend.git
	src/modules/Member/Backend:git@gitee.com:zidaibudai/member-backend.git
	src/modules/Server:git@gitee.com:zidaibudai/Server.git
	src/modules/Shop/Backend:git@gitee.com:zidaibudai/shop-backend.git
	src/modules/Store/Backend:git@gitee.com:zidaibudai/store-backend.git
	src/modules/Store/Frontend:git@gitee.com:zidaibudai/joyoutdoor-store.git
	src/modules/Store/ContentHub:git@gitee.com:zidaibudai/content-hub-pc.git
	src/modules/Wechat/Backend:git@gitee.com:zidaibudai/wechat-backend.git
	src/modules/Wechat/Server:git@gitee.com:zidaibudai/wechat-server.git
		" --tags=$TAGS

        popd

    done

popd

rm -rf ./.split
	