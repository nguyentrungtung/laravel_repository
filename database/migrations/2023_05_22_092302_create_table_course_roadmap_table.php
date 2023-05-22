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
        Schema::create('course_roadmap', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('image')->comment('Ảnh phương thức');
            $table->text('content')->comment('Nội dung phương thức');
            $table->tinyInteger('course_id')->comment('id khóa học');
            $table->integer('ordering')->default(1)->comment('Thứ tự');
            $table->tinyInteger('status')->default(1)->comment('0: Không hoạt động; 1: Hoạt động');
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
        Schema::dropIfExists('course_roadmap');
    }
};
