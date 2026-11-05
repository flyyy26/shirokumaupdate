
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($sitemaps as $sitemap)
    <sitemap>
        <loc>{{ url($sitemap['loc']) }}</loc>
        <lastmod>{{ $sitemap['lastmod'] ?? now()->toW3CString() }}</lastmod>
    </sitemap>
    @endforeach
</sitemapindex>