<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsUserFavoriteRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports_user_favorite_refs', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('report_id');
            $table->boolean('del_flag')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('report_id')->references('id')->on('talents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports_user_favorite_refs');
    }
}