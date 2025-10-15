<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); 
            $table->string('title')->nullable();
            $table->longText('excerpt')->nullable();
            $table->string('author')->nullable();
            $table->string('date')->nullable();
            $table->string('read_time')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();    
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade'); 
            $table->string('image')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
