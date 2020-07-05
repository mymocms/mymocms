<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('other_name', 250)->nullable();
            $table->string('thumbnail', 250)->nullable();
            $table->string('poster', 250)->nullable();
            $table->string('slug', 200)->unique()->index();
            $table->longText('description')->nullable();
            $table->string('actors', 250)->nullable();
            $table->string('directors', 250)->nullable();
            $table->string('writers', 250)->nullable();
            $table->string('rating', 25)->nullable();
            $table->string('release', 15)->nullable();
            $table->string('countries', 250)->nullable();
            $table->string('genres', 250)->nullable();
            $table->string('tags', 250)->nullable();
            $table->string('runtime', 100)->nullable();
            $table->string('video_quality', 100)->nullable();
            $table->string('trailer_link', 100)->nullable();
            $table->integer('current_episode')->nullable();
            $table->integer('max_episode')->nullable();
            $table->tinyInteger('tv_series')->default(0);
            $table->tinyInteger('is_paid')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
