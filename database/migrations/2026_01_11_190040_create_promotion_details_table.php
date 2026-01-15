<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('promotion_details', function (Blueprint $table) {
      $table->id();
      $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
      $table->string('icon')->default('check');
      $table->string('text');
      $table->unsignedInteger('position')->default(0);
      $table->timestamps();

      $table->index(['promotion_id', 'position']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('promotion_details');
  }
};
