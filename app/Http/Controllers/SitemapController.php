<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Gallery;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // Data statis
        $staticUrls = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => '/tentang-kami', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => '/legalitas', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/engineering', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/ginoujisshusei', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/tg', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/kaigo', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/nihongo-gakkou', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/pertanyaan-umum', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => '/kontak', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/galeri', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => '/syarat-ketentuan', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['loc' => '/kebijakan-privasi', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['loc' => '/download-formulir', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/lowongan-kerja', 'priority' => '0.8', 'changefreq' => 'daily'],
        ];

        // Data dinamis
        $dynamicUrls = [];

        // FAQ
        $faqs = Faq::where('is_active', true)->get();
        foreach ($faqs as $faq) {
            $dynamicUrls[] = [
                'loc' => '/pertanyaan-umum#' . $faq->id,
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => $faq->updated_at->toW3CString(),
            ];
        }

        // Gallery
        $galleries = Gallery::where('is_active', true)->get();
        foreach ($galleries as $gallery) {
            $dynamicUrls[] = [
                'loc' => '/galeri#' . $gallery->id,
                'priority' => '0.5',
                'changefreq' => 'monthly',
                'lastmod' => $gallery->updated_at->toW3CString(),
            ];
        }

        // Job Vacancies
        $jobs = JobVacancy::where('is_active', true)->get();
        foreach ($jobs as $job) {
            $dynamicUrls[] = [
                'loc' => '/lowongan-kerja/' . $job->slug,
                'priority' => '0.8',
                'changefreq' => 'daily',
                'lastmod' => $job->updated_at->toW3CString(),
            ];
        }

        // Gabungkan semua URL
        $allUrls = array_merge($staticUrls, $dynamicUrls);

        return response()->view('sitemap', ['urls' => $allUrls])
            ->header('Content-Type', 'text/xml');
    }

    // Sitemap index (jika banyak sitemap)
    public function indexSitemap()
    {
        $sitemaps = [
            ['loc' => '/sitemap.xml', 'lastmod' => now()->toW3CString()],
        ];

        return response()->view('sitemap-index', ['sitemaps' => $sitemaps])
            ->header('Content-Type', 'text/xml');
    }
}