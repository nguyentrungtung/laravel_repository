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
        Schema::create('course_lession', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->comment('Tên Audio bài học');
            $table->string('exercise_link')->comment('Link bài tập');
            $table->integer('ordering')->default(1)->comment('Thứ tự');
            $table->tinyInteger('status')->default(1)->comment('0: Không hoạt động; 1: Hoạt động');
            $table->tinyInteger('course_id')->comment('id khóa học');
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
        Schema::dropIfExists('course_lession');
    }
};
