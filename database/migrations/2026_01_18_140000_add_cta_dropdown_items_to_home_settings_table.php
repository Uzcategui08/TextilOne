<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('home_settings', function (Blueprint $table) {
      // Array of items: [{label: string, url: string}]
      $table->jsonb('cta_dropdown_items')->nullable()->after('cta_url');
    });
  }

  public function down(): void
  {
    Schema::table('home_settings', function (Blueprint $table) {
      $table->dropColumn('cta_dropdown_items');
    });
  }
};
