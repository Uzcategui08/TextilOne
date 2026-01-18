<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('home_products', function (Blueprint $table) {
      $table->foreignId('image_media_id')->nullable()->constrained('media_files')->nullOnDelete()->after('image_path');
    });

    Schema::table('promotions', function (Blueprint $table) {
      $table->foreignId('image_media_id')->nullable()->constrained('media_files')->nullOnDelete()->after('image_path');
    });

    Schema::table('companies', function (Blueprint $table) {
      $table->foreignId('logo_media_id')->nullable()->constrained('media_files')->nullOnDelete()->after('logo_path');
    });

    Schema::table('home_settings', function (Blueprint $table) {
      $table->foreignId('logo_media_id')->nullable()->constrained('media_files')->nullOnDelete()->after('logo_path');
    });
  }

  public function down(): void
  {
    Schema::table('home_products', function (Blueprint $table) {
      $table->dropConstrainedForeignId('image_media_id');
    });

    Schema::table('promotions', function (Blueprint $table) {
      $table->dropConstrainedForeignId('image_media_id');
    });

    Schema::table('companies', function (Blueprint $table) {
      $table->dropConstrainedForeignId('logo_media_id');
    });

    Schema::table('home_settings', function (Blueprint $table) {
      $table->dropConstrainedForeignId('logo_media_id');
    });
  }
};
