<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('author')->nullable();
            $table->tinyInteger('post_id')->nullable();
            $table->longText('comment')->nullable();
            $table->longText('rep')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
};
