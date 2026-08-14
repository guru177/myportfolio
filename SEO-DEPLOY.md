# Post-deploy SEO & indexing checklist

Run these steps after deploying to your live domain (update `site_url` in `config.php` first).

## 1. Domain & config

- [ ] Set `site_url` in `config.php` to your real HTTPS domain
- [ ] Add your WhatsApp number to `whatsapp` in `config.php` (enables schema telephone + WhatsApp CTAs)
- [ ] Add real LinkedIn profile to `same_as` and footer `social` if available
- [ ] Add `google_business_url` if you have a Google Business Profile
- [ ] Uncomment HTTPS redirect in `.htaccess` once SSL is live

## 2. Crawl & index

- [ ] Open `https://yourdomain.com/robots.txt` — confirm Sitemap URL matches your domain
- [ ] Open `https://yourdomain.com/sitemap.xml` — confirm homepage URL is correct
- [ ] Open `https://yourdomain.com/llms.txt` — confirm AEO summary loads

## 3. Google Search Console

- [ ] Add property for your domain
- [ ] Submit sitemap: `https://yourdomain.com/sitemap.xml`
- [ ] Use URL Inspection on homepage → Request indexing

## 4. Bing Webmaster Tools

- [ ] Add site and submit the same sitemap URL

## 5. Rich results & social previews

- [ ] [Google Rich Results Test](https://search.google.com/test/rich-results) — validate FAQPage, Person, ProfessionalService
- [ ] [Facebook Sharing Debugger](https://developers.facebook.com/tools/debug/) — verify OG image (1200×630)
- [ ] [Twitter Card Validator](https://cards-dev.twitter.com/validator) — verify card preview (if using Twitter/X)

## 6. Mobile & performance

- [ ] [Google Mobile-Friendly Test](https://search.google.com/test/mobile-friendly)
- [ ] [PageSpeed Insights](https://pagespeed.web.dev/) — note LCP, CLS, INP baseline

## 7. Browser smoke test

- [ ] Chrome (desktop + mobile)
- [ ] Firefox
- [ ] Safari (iOS if possible)
- [ ] Edge

Check: hero, nav anchors, FAQ accordion, contact form, skip link (Tab key → “Skip to content”).

## 8. Optional ongoing

- [ ] Replace sample case studies with real client stories
- [ ] Add approved testimonials to `config.php` → `testimonials.items`
- [ ] Monitor GSC Coverage and Core Web Vitals monthly
