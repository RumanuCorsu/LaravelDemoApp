<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table){
            $table->unsignedBigInteger('video_id')->nullable();
            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onDelete('set null');
            $table->unsignedBigInteger('article_id')->nullable();
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table){
            $table->dropForeign(['video_id']);
            $table->dropForeign(['article_id']);
            $table->dropColumn('video_id');
            $table->dropColumn('article_id');
        });
    }
};
