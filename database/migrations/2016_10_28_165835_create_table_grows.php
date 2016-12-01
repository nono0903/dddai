<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//具体收益表
        Schema::create('grows', function (Blueprint $table) {
            $table->increments('gid');// 主键
            $table->integer('uid');//用户uid
            $table->integer('pid');//项目pid
            $table->string('title');//项目名称
            $table->integer('amount');//每天产生的利息
            $table->date('paytime');//收益时间

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grows');
    }
}
