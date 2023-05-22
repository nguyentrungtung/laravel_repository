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
        //
        Schema::create('course_lession_audio', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('lession_id')->comment('id lộ trình khóa học');
            $table->string('audio',255)->comment('link file audio khóa học');
            $table->string('audio_name',255)->comment('Tên audio');
            $table->string('image')->comment('Ảnh audio');
            $table->string('course_name',255)->comment('name danh mục khóa học');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_lession_audio');
    }
};
