<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('ibrand.app.database.prefix', 'ibrand_');

        if (!Schema::hasTable($prefix . 'user_details')) {
            Schema::create($prefix . 'user_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('mobile')->nullable();
                $table->string('name')->nullable();
                $table->string('id_card')->nullable();
                $table->string('company')->nullable();
                $table->string('job')->nullable();
                $table->string('weibo')->nullable();
                $table->string('weixin')->nullable();
                $table->string('qq')->nullable();
                $table->string('homepage')->nullable();
                $table->string('signature')->nullable();
                $table->text('about')->nullable();
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
        $prefix = config('ibrand.app.database.prefix', 'ibrand_');

        Schema::dropIfExists($prefix . 'user_details');
    }
}
