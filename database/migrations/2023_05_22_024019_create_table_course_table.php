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
        // Khóa học
        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('summary')->comment('Tóm tắt khóa học');
            $table->tinyInteger('status')->default(1)->comment('0: Không hoạt động; 1: Hoạt động');
            $table->tinyInteger('categories_id')->comment('id danh mục khóa học');
            $table->string('categories_name',255)->comment('name danh mục khóa học');
            $table->string('image')->comment('Ảnh khóa học');
            $table->string('audio',255)->comment('link file audio khóa học');
            $table->string('audio_name',255)->comment('Tên audio khóa học');
            $table->string('method_summary')->comment('Nội dung phương thức học');
            $table->text('content')->comment('Nội dung giá trị của khóa học');
            $table->text('content_support')->comment('Nội dung hỗ trợ trong quá trình học');
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
        Schema::dropIfExists('course');
    }
};
