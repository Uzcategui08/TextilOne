<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('promotions', function (Blueprint $table) {
      $table->id();
      $table->unsignedTinyInteger('carousel_group')->default(1);
      $table->unsignedInteger('position')->default(0);
      $table->boolean('is_active')->default(true);

      $table->string('title');
      $table->text('description')->nullable();
      $table->string('image_path')->nullable();
      $table->string('badge_icon')->default('star');

      $table->timestamps();

      $table->index(['carousel_group', 'position']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('promotions');
  }
};
