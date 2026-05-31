<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('external_id')->unique()->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();

            $table->string('title')->nullable();
            $table->string('slug')->nullable();

            $table->text('description')->nullable();

            $table->string('location')->nullable();
            $table->string('suburb')->nullable();

            $table->decimal('price_offer', 15, 2)->nullable();

            $table->string('type')->nullable();
            $table->string('status')->nullable();

            $table->json('photos')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
