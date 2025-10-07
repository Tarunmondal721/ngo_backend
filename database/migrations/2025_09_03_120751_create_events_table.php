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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable(); 
            $table->string('location')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();    
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade'); 
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('attendees')->nullable();
            $table->string('impact')->nullable();
            $table->string('status')->default('processing');
            $table->string('price')->default('free'); 
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
