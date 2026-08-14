# Guru Portfolio — Custom PHP

SEO-friendly portfolio built with plain PHP, semantic HTML, and reusable includes.

## Structure

```
├── index.php           # Homepage
├── config.php          # Site & SEO settings
├── sitemap.php         # Dynamic XML sitemap
├── includes/
│   ├── head.php        # Meta tags, Open Graph, JSON-LD
│   ├── header.php      # Navigation
│   ├── hero.php        # Hero section
│   ├── client-logos.php
│   └── footer.php
└── assets/
    ├── css/
    ├── images/
    └── favicon.svg
```

## Run locally

```bash
php -S localhost:8000
```

Open [http://localhost:8000](http://localhost:8000)

## SEO

Edit `config.php` for title, description, and canonical URL (`site_url`). Each page can override `$pageTitle`, `$pageDescription`, and `$canonicalUrl` before including `head.php`.

Included out of the box:

- Semantic HTML (`main`, `header`, `nav`, `h1`)
- Meta description, Open Graph & Twitter cards
- JSON-LD (Person, ProfessionalService, WebSite, WebPage, FAQPage, BreadcrumbList)
- Dynamic `robots.php` & `sitemap.php` (routed via `.htaccess`)
- `llms.txt` for AI/answer-engine crawlers
- Canonical URLs & hreflang

**Before deploying:** update `site_url` in `config.php`, then follow [SEO-DEPLOY.md](SEO-DEPLOY.md).

## Deploy

Upload to any PHP host (Apache/Nginx). Ensure `mod_rewrite` is enabled for `.htaccess`, or point the document root to this folder.

For Nginx, route `/sitemap.xml` to `sitemap.php`.
