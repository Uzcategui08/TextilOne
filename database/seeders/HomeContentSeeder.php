<?php

namespace Database\Seeders;

use App\Models\HomeProduct;
use App\Models\HomeService;
use App\Models\HomeSetting;
use App\Models\Promotion;
use App\Models\PromotionDetail;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
  public function run(): void
  {
    // Seed singleton settings (keep existing if already set).
    $settings = HomeSetting::query()->first() ?? HomeSetting::query()->create([]);

    $settings->fill([
      'site_title' => 'Textilone Chile - Personalización de Textiles',
      'nav_services' => 'Servicios',
      'nav_promotions' => 'Promociones',
      'nav_contact' => 'Contacto',
      'hero_title' => 'Personalización de Textiles de Alta Calidad',
      'hero_subtitle' => 'Especialistas en estampados, bordados y sublimación para tu empresa',
      'cta_text' => 'Cotiza ahora',
      'cta_url' => '#',
      'services_title' => 'Nuestros Servicios',
      'promotions_title' => 'Promociones Exclusivas',
      'products_title' => 'Nuestros Productos',
      'guarantee_title' => 'Garantía de 3 Meses',
      'guarantee_text' => 'Calidad asegurada en todos nuestros productos. Realizamos envíos a todo Chile.',
      'phone' => '+56 9 XXXX XXXX',
      'email' => 'contacto@textilonechile.cl',
      'location' => 'Santiago, Chile',
      'copyright_text' => '© 2025 Textilone Chile. Todos los derechos reservados.',
    ]);

    $settings->save();

    // Services.
    if (HomeService::query()->count() === 0) {
      HomeService::query()->create([
        'icon' => 'print',
        'title' => 'Estampados',
        'description' => 'Impresión de alta calidad en todo tipo de textiles',
        'position' => 1,
        'is_active' => true,
      ]);
      HomeService::query()->create([
        'icon' => 'gesture',
        'title' => 'Bordados',
        'description' => 'Acabados profesionales con bordado a máquina',
        'position' => 2,
        'is_active' => true,
      ]);
      HomeService::query()->create([
        'icon' => 'palette',
        'title' => 'Accesorios',
        'description' => 'Impresión completa con colores vibrantes y duraderos',
        'position' => 3,
        'is_active' => true,
      ]);
    }

    // Products.
    if (HomeProduct::query()->count() === 0) {
      HomeProduct::query()->create([
        'image_text' => 'Polerones personalizados',
        'title' => 'Polerones Canguro',
        'subtitle' => 'Comodidad y estilo con tu diseño',
        'position' => 1,
        'is_active' => true,
      ]);
      HomeProduct::query()->create([
        'image_text' => 'Poleras personalizadas',
        'title' => 'Poleras MC',
        'subtitle' => '100% algodón, perfectas para cualquier ocasión',
        'position' => 2,
        'is_active' => true,
      ]);
      HomeProduct::query()->create([
        'image_text' => 'Jockeys personalizados',
        'title' => 'Jockeys',
        'subtitle' => 'Profesionales y resistentes',
        'position' => 3,
        'is_active' => true,
      ]);
      HomeProduct::query()->create([
        'image_text' => 'Cortavientos personalizados',
        'title' => 'Cortavientos',
        'subtitle' => 'Protección contra el viento con tu marca',
        'position' => 4,
        'is_active' => true,
      ]);
    }

    // Social links.
    if (SocialLink::query()->count() === 0) {
      SocialLink::query()->create(['icon' => 'alternate_email', 'url' => '#', 'position' => 1, 'is_active' => true]);
      SocialLink::query()->create(['icon' => 'photo_camera', 'url' => '#', 'position' => 2, 'is_active' => true]);
      SocialLink::query()->create(['icon' => 'language', 'url' => '#', 'position' => 3, 'is_active' => true]);
    }

    // Promotions + details.
    if (Promotion::query()->count() === 0) {
      $promotions = [
        [
          'title' => 'Pack Básico',
          'description' => '(1) Polerón Canguro + (1) Jockey a partir de 3 promociones o 2 packs',
          'details' => [
            ['icon' => 'straighten', 'text' => 'Tallas S a XXL'],
            ['icon' => 'palette', 'text' => '1 o 2 estampados full color'],
            ['icon' => 'checkroom', 'text' => '70% algodón/30% poliéster'],
          ],
        ],
        [
          'title' => 'Pack Completo',
          'description' => '(1) Polera MC + (1) Cortaviento + (1) Jockey a partir de 2 packs',
          'details' => [
            ['icon' => 'straighten', 'text' => 'Tallas S a XXL'],
            ['icon' => 'palette', 'text' => '1 o 2 estampados full color'],
            ['icon' => 'checkroom', 'text' => '100% algodón y poliéster'],
          ],
        ],
        [
          'title' => 'Pack Premium',
          'description' => '(1) Polera MC + (1) Polerón Canguro + (1) Jockey a partir de 2 packs o 3 unidades',
          'details' => [
            ['icon' => 'straighten', 'text' => 'Tallas S a XXL'],
            ['icon' => 'palette', 'text' => '1 o 2 estampados full color'],
            ['icon' => 'checkroom', 'text' => 'Algodón y poliéster de calidad'],
          ],
        ],
        [
          'title' => 'Pack Empresa',
          'description' => '(5) Poleras + (5) Gorras para uniformes corporativos',
          'details' => [
            ['icon' => 'apartment', 'text' => 'Ideal para equipos'],
            ['icon' => 'palette', 'text' => 'Logo full color'],
            ['icon' => 'local_shipping', 'text' => 'Envíos a todo Chile'],
          ],
        ],
        [
          'title' => 'Pack Deportista',
          'description' => '(3) Poleras dry-fit + (1) Cortaviento',
          'details' => [
            ['icon' => 'fitness_center', 'text' => 'Tela deportiva'],
            ['icon' => 'palette', 'text' => 'Estampado resistente'],
            ['icon' => 'schedule', 'text' => 'Entrega rápida'],
          ],
        ],
        [
          'title' => 'Pack Bordado Pro',
          'description' => '(3) Poleras + (1) Chaqueta con bordado premium',
          'details' => [
            ['icon' => 'gesture', 'text' => 'Bordado a máquina'],
            ['icon' => 'verified', 'text' => 'Terminación profesional'],
            ['icon' => 'straighten', 'text' => 'Tallas S a XXL'],
          ],
        ],
        [
          'title' => 'Pack Sublimación',
          'description' => '(2) Poleras full print + (1) Jockey',
          'details' => [
            ['icon' => 'palette', 'text' => 'Colores vibrantes'],
            ['icon' => 'checkroom', 'text' => 'Tela poliéster'],
            ['icon' => 'local_offer', 'text' => 'Promo limitada'],
          ],
        ],
        [
          'title' => 'Pack Emprendedor',
          'description' => '(10) Stickers textiles + (2) Poleras con marca',
          'details' => [
            ['icon' => 'storefront', 'text' => 'Para tu marca'],
            ['icon' => 'palette', 'text' => 'Diseño personalizado'],
            ['icon' => 'support_agent', 'text' => 'Asesoría incluida'],
          ],
        ],
        [
          'title' => 'Pack Eventos',
          'description' => '(10) Poleras + (10) Credenciales (diseño)',
          'details' => [
            ['icon' => 'event', 'text' => 'Perfecto para ferias'],
            ['icon' => 'palette', 'text' => 'Identidad visual'],
            ['icon' => 'groups', 'text' => 'Para equipos grandes'],
          ],
        ],
        [
          'title' => 'Pack Seguridad',
          'description' => '(2) Cortavientos + (2) Poleras con identificación',
          'details' => [
            ['icon' => 'shield', 'text' => 'Alta visibilidad'],
            ['icon' => 'verified', 'text' => 'Material resistente'],
            ['icon' => 'local_shipping', 'text' => 'Despacho disponible'],
          ],
        ],
        [
          'title' => 'Pack Full Marca',
          'description' => '(2) Polerones + (2) Poleras + (2) Jockeys',
          'details' => [
            ['icon' => 'star', 'text' => 'Kit completo'],
            ['icon' => 'palette', 'text' => 'Branding full'],
            ['icon' => 'checkroom', 'text' => 'Calidad premium'],
          ],
        ],
        [
          'title' => 'Pack Mayorista',
          'description' => '(20) unidades mixtas a elección (poleras/jockeys)',
          'details' => [
            ['icon' => 'inventory_2', 'text' => 'Precio por volumen'],
            ['icon' => 'palette', 'text' => 'Diseños a elección'],
            ['icon' => 'support_agent', 'text' => 'Soporte dedicado'],
          ],
        ],
      ];

      foreach ($promotions as $index => $promoData) {
        $group = intdiv($index, 4) + 1;
        $position = ($index % 4) + 1;

        $promo = Promotion::query()->create([
          'carousel_group' => $group,
          'position' => $position,
          'is_active' => true,
          'title' => $promoData['title'],
          'description' => $promoData['description'],
          'badge_icon' => 'star',
        ]);

        foreach ($promoData['details'] as $detailIndex => $detail) {
          PromotionDetail::query()->create([
            'promotion_id' => $promo->id,
            'icon' => $detail['icon'],
            'text' => $detail['text'],
            'position' => $detailIndex + 1,
          ]);
        }
      }
    }
  }
}
