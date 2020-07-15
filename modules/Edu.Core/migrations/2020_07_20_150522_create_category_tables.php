<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('ibrand.app.database.prefix', 'ibrand_').'edu_';
        if (!Schema::hasTable($prefix . 'category')) {
            Schema::create($prefix . 'category', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 64)->default('')->unique('uri');
                $table->string('name');
                $table->string('path')->default('');
                $table->integer('weight')->default(0);
                $table->integer('course_count')->default(0);
                $table->integer('groupId')->unsigned()->index('group_index');
                $table->integer('parent_id')->unsigned()->nullable()->default(0);
                $table->integer('level')->default(0);
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
        Schema::drop('category');
    }

}
