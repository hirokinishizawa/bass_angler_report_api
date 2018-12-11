<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('size');
            $table->string('prefectures', 100);
            $table->string('address', 100);
            $table->string('description', 100)->nullable();
            $table->string('image_filename', 100)->nullable();
            $table->integer('goods_count')->default(0);
            $table->unsignedInteger('user_id');
            $table->boolean('del_flag')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
