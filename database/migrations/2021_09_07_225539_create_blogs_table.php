<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title',150)->nullable();
            $table->string('url',150)->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('category_list')->nullable();
            $table->string('image',100)->nullable();

            $table->string('seo_title',100)->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('search_keywords')->nullable();

            $table->string('creator',100)->nullable();
            $table->string('slug',100)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('blog_blog_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_id')->nullable();
            $table->bigInteger('blog_category_id')->nullable();
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
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_blog_category');
    }
}
