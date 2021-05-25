<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('description', 300)->nullable();
            $table->string('slug', 150)->unique()->index();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('post_categories');
    }
}