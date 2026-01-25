<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController
{
  public function __invoke(): Response
  {
    $baseUrl = rtrim(url('/'), '/');
    $lastMod = now()->toDateString();

    $urls = [
      [
        'loc' => $baseUrl . '/',
        'lastmod' => $lastMod,
        'changefreq' => 'weekly',
        'priority' => '1.0',
      ],
    ];

    $xml = view('sitemap.xml', compact('urls'));

    return response($xml, 200)
      ->header('Content-Type', 'application/xml; charset=UTF-8');
  }
}
