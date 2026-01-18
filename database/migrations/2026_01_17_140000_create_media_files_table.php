<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('media_files', function (Blueprint $table) {
      $table->id();
      $table->string('original_name')->nullable();
      $table->string('filename')->nullable();
      $table->string('mime_type')->nullable();
      $table->unsignedBigInteger('size')->nullable();
      $table->string('sha256', 64)->nullable();
      $table->binary('data');
      $table->timestamps();

      $table->index('sha256');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('media_files');
  }
};
