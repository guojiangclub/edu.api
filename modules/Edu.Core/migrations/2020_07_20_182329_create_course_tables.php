<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('ibrand.app.database.prefix', 'ibrand_').'edu_';

        if (!Schema::hasTable($prefix . 'course')) {
            Schema::create($prefix . 'course', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title')->comment('标题');
                $table->string('subtitle')->nullable()->comment('副标题');
                $table->enum('status', array('draft', 'published', 'closed'))->default('draft')->index('status_index')->comment('课程状态');
                $table->unsignedInteger('price')->default(0); //课程价格,单位分
                $table->integer('expiry_day')->unsigned()->default(0); //过期天数
                $table->unsignedInteger('income')->default(0)->comment('课程销售总收入');
                $table->integer('lesson_count')->unsigned()->default(0); //课时数量
                $table->string('tags')->nullable(); //标签，现在系统中未使用
                $table->text('about')->nullable();   //课程描述
                $table->string('picture')->nullable(); //课程图片
                $table->boolean('recommended')->default(0)->comment('是否为推荐课程');
                $table->integer('recommended_seq')->unsigned()->default(0);  //推荐排序
                $table->timestamp('recommended_time')->nullable()->comment('推荐时间');
                $table->integer('student_count')->unsigned()->default(0);  //学员总数
                $table->integer('view_count')->unsigned()->default(0)->comment('查看次数');
                $table->integer('user_id')->default(0)->comment('创建用户ID');
                $table->boolean('is_discount')->nullable()->default(0);  //是否促销
                $table->unsignedInteger('discount_price')->nullable()->default(0);  //促销价格，单位分
                $table->timestamp('discount_start_time')->nullable();  //促销开始时间
                $table->timestamp('discount_end_time')->nullable();//促销结束时间
                $table->timestamps();

            });
        }
        if (!Schema::hasTable($prefix . 'course_announcement')) {  //课程公告
            Schema::create($prefix . 'course_announcement', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id')->default(0);
                $table->unsignedInteger('course_id');
                $table->text('content');  //公告内容
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_category')) {  //课程和分类关联表
            Schema::create($prefix . 'course_category', function (Blueprint $table) {
                $table->integer('course_id')->unsigned();
                $table->integer('category_id')->unsigned()->index('course_category_category_id_foreign');
                $table->integer('group_id')->nullable();
                $table->primary(['course_id', 'category_id']);
            });
        }

        if (!Schema::hasTable($prefix . 'course_chapter')) {   //课程章节
            Schema::create($prefix . 'course_chapter', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id')->unsigned();
                $table->integer('number')->unsigned();  //和课时的顺序数字
                $table->integer('seq')->unsigned();   //排列顺序
                $table->string('title');   //章节名称
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_favorite')) {   //课程收藏，但是在新的小程序中未实现收藏功能，暂时可以无视
            Schema::create($prefix . 'course_favorite', function (Blueprint $table) {
                $table->increments('id')->comment('收藏的id');
                $table->integer('course_id')->unsigned()->comment('收藏课程的Id');
                $table->integer('user_id')->default(0)->comment('收藏人的Id');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_lesson')) {
            Schema::create($prefix . 'course_lesson', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id')->unsigned();  //课程ID
                $table->integer('chapter_id')->unsigned()->default(0);//章节ID，课时可以属于某个章节，也可以不属于
                $table->integer('number')->unsigned();   //
                $table->integer('seq')->unsigned()->index('seq_index');
                $table->boolean('free')->default(0);   //是否免费，免费课时，不加入课程也可观看
                $table->tinyInteger('status')->default(1);  //课时状态
                $table->string('title');  //课时名称
                $table->text('summary')->nullable(); //课时描述
                $table->string('tags')->nullable();  //标签，没有使用
                $table->string('type')->default('video'); //课时类型，可以时视频，语音，图文，直播。现在默认都是视频
                $table->text('content')->nullable();  //课时内容，图文课时使用
                $table->string('media_id')->nullable()->comment('媒体文件ID(user_disk_file.id)');
                $table->string('media_source', 32)->default('aliyun')->comment('媒体文件来源(self:本站上传,youku:优酷)');
                $table->string('media_name')->default('')->comment('媒体文件名称');
                $table->string('media_uri', 1024)->nullable()->comment('媒体文件资源名');
                $table->integer('length')->unsigned()->nullable()->comment('视频，音频，文章阅读时长');
                $table->integer('learned_count')->unsigned()->default(0); //课时被学习的数量
                $table->integer('view_count')->unsigned()->default(0);//课时被打开的次数
                $table->integer('thread_count')->unsigned()->default(0)->comment('问题数量');
                $table->integer('user_id')->unsigned()->default(0)->comment('课时创建用户id');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_member')) { //课程学员表
            Schema::create($prefix . 'course_member', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id')->unsigned();
                $table->integer('user_id')->unsigned()->default(0)->comment('对应uid');
                $table->integer('order_id')->unsigned()->default(0)->comment('学员购买课程时的订单ID');
                $table->timestamp('deadline')->nullable()->comment('过期时间');
                $table->integer('learned_count')->unsigned()->default(0);  //表示该课程学习完的课时数量
                $table->boolean('is_learned')->default(0); //该课程是否已经完成学习
                $table->integer('seq')->unsigned()->default(0); //无用字段
                $table->string('remark')->default('')->comment('备注');
                $table->boolean('is_visible')->default(1)->comment('可见与否，默认为可见'); //无用字段
                $table->enum('role', array('student', 'teacher'))->default('student');  //不会有teacher值，后续会弃用，因为已经新增 course_teacher
                $table->boolean('locked')->default(0);  //课时是否锁定，暂时不用
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_order')) {  //课程订单
            Schema::create($prefix . 'course_order', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->string('sn', 32)->unique('sn');  //订单编号
                $table->enum('status', array('created', 'paid', 'refunding', 'refunded', 'cancelled')); // 订单状态，目前只使用 created,paid
                $table->string('title');  //订单标题，通常是课程名称
                $table->integer('course_id')->unsigned();  //
                $table->integer('items_total')->unsigned()->default(0);  // 课程原价
                $table->integer('adjustments_total')->default(0);  //优惠金额，负数
                $table->integer('total')->unsigned()->default(0);  //实际需要支付金额
                $table->string('payment', 32)->nullable()->default('none');   // 支付渠道
                $table->timestamp('paid_at')->nullable();  //支付时间
                $table->text('note')->nullable();  //备注
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_order_adjustment')) {  //
            Schema::create($prefix . 'course_order_adjustment', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('order_id')->unsigned()->nullable();
                $table->string('type');  //优惠对象，订单, 商品，运费等
                $table->string('label')->nullable();  // 文案描述："9折"
                $table->integer('amount')->default(0);  //优惠金额，统一用分来表示
                $table->string('origin_type')->nullable();   //优惠类型
                $table->integer('origin_id')->default(0);     //优惠券ID或者

                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_review')) { //课程评价，暂时未使用
            Schema::create($prefix . 'course_review', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->comment('评价user_id');
                $table->integer('course_id')->unsigned();
                $table->string('title')->default('')->comment('评论title');
                $table->text('content')->comment('评论内容');
                $table->integer('rating')->unsigned()->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable($prefix . 'course_teacher')) { //课程讲师，主要存储课程需要显示的讲师名称和头像
            Schema::create($prefix . 'course_teacher', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->string('name')->nullable();
                $table->string('avatar')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = config('ibrand.app.database.prefix', 'ibrand_').'edu_';
        Schema::drop($prefix . 'course_teacher');
        Schema::drop($prefix . 'course_review');
        Schema::drop($prefix . 'course_order');
        Schema::drop($prefix . 'course_member');
        Schema::drop($prefix . 'course_lesson');
        Schema::drop($prefix . 'course_favorite');
        Schema::drop($prefix . 'course_chapter');
        Schema::drop($prefix . 'course_category');
        Schema::drop($prefix . 'course_announcement');
        Schema::drop($prefix . 'course');
    }
}
