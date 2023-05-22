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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->nullable();
            $table->string('post_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('summary')->nullable();
            $table->string('author')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('label')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('slug')->nullable();
            $table->string('user_id')->default(1);
            $table->longText('info_admin')->nullable();
            $table->json('schema');
            $table->text('meta_robot');
            $table->string('seo_description')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->string('seo_canonical')->nullable();
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
        Schema::dropIfExists('posts');
    }
};
