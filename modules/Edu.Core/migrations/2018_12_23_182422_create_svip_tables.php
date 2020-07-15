<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSvipTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vip_plan')) {
            Schema::create('vip_plan', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->unsignedTinyInteger('status')->default(1);
                $table->unsignedInteger('member_count')->default(0);
                $table->unsignedInteger('price')->default(0);
                $table->integer('days')->default(365); //会员有效期天数，默认一年
                $table->text('actions')->nullable();
                $table->tinyInteger('is_discount')->default(0);
                $table->unsignedInteger('discount_price')->default(0);
                $table->timestamp('discount_starts_at')->nullable();
                $table->timestamp('discount_ends_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('vip_member')) {
            Schema::create('vip_member', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedTinyInteger('status')->default(1);
                $table->unsignedInteger('plan_id');
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('order_id');
                $table->timestamp('joined_at')->nullable();
                $table->timestamp('deadline')->nullable()->comment('过期时间');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('vip_order')) {
            Schema::create('vip_order', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_no');
                $table->integer('status')->default(0);
                $table->unsignedInteger('plan_id');
                $table->unsignedInteger('user_id');
                $table->string('channel')->nullable();
                $table->string('out_trade_no')->nullable();
                $table->string('transaction_no')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->integer('price');
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
        Schema::dropIfExists('vip_order');
        Schema::dropIfExists('vip_member');
        Schema::dropIfExists('vip_plan');
    }
}
