<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('home_settings', function (Blueprint $table) {
      $table->id();
      $table->string('site_title')->nullable();
      $table->string('logo_path')->nullable();

      $table->string('nav_services')->default('Servicios');
      $table->string('nav_promotions')->default('Promociones');
      $table->string('nav_contact')->default('Contacto');

      $table->string('hero_title')->default('Personalización de Textiles de Alta Calidad');
      $table->string('hero_subtitle')->default('Especialistas en estampados, bordados y sublimación para tu empresa');
      $table->string('cta_text')->default('Cotiza ahora');
      $table->string('cta_url')->default('#');

      $table->string('services_title')->default('Nuestros Servicios');
      $table->string('promotions_title')->default('Promociones Exclusivas');
      $table->string('products_title')->default('Nuestros Productos');

      $table->string('guarantee_title')->default('Garantía de 3 Meses');
      $table->text('guarantee_text')->default('Calidad asegurada en todos nuestros productos. Realizamos envíos a todo Chile.');

      $table->string('phone')->nullable();
      $table->string('email')->nullable();
      $table->string('location')->nullable();
      $table->string('copyright_text')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('home_settings');
  }
};
