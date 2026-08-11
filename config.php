<?php

declare(strict_types=1);

$config = [
    'site_name' => 'Guru.',
    'site_url' => 'https://guru.dev',
    'locale' => 'en_IN',
    'author' => 'Guruprasad',
    'email' => 'hello@guru.dev',
    'location' => 'Kochi, Kerala',
    'title' => 'Guru — Full Stack Webdeveloper in Kochi, Kerala',
    'description' => 'Guruprasad is a freelance full stack webdeveloper based in Kochi, Kerala. Building modern web apps, websites, and digital products.',
    'keywords' => 'full stack developer, webdeveloper, Kochi, Kerala, freelance developer, web apps',
    'og_image' => '/assets/images/portrait.png',
    'role_primary' => 'Full Stack',
    'role_secondary' => 'Webdeveloper',
    'intro' => 'my name is Guruprasad and I am a freelance',
    'cta_primary' => ['label' => 'You need a Developer', 'href' => '#contact'],
    'cta_secondary' => ['label' => 'You need a Webapp', 'href' => '#projects'],
    'nav' => [
        ['label' => 'Design', 'href' => '#design'],
        ['label' => 'Photos', 'href' => '#photos'],
        ['label' => 'About', 'href' => '#about'],
    ],
    'clients' => ['laravel', 'node', 'electron', 'php', 'html'],
    'marquee' => [
        'strip_one' => [
            'Full Stack Development',
            'Web Applications',
            'Laravel & PHP',
            'Node.js APIs',
            'Clean UI / UX',
            'Freelance Projects',
            'Kochi, Kerala',
        ],
        'strip_two' => [
            'Electron Apps',
            'Responsive Websites',
            'Modern Frontends',
            'Scalable Backends',
            'Fast Delivery',
            'Open to Work',
            'hello@guru.dev',
        ],
    ],
    'about' => [
        'side_nav' => [
            ['label' => 'About', 'href' => '#about'],
            ['label' => 'Work', 'href' => '#projects'],
            ['label' => 'Stack', 'href' => '#about-info'],
            ['label' => 'Contact', 'href' => '#contact'],
        ],
        'eyebrow' => 'Freelance Full Stack · Kochi, Kerala',
        'title_lead' => 'Web',
        'title' => 'Developer',
        'body' => 'I build modern web applications with clean architecture, sharp interfaces, and reliable delivery — from Laravel backends and Node APIs to polished frontends that feel fast on every device.',
        'meta' => [
            ['label' => 'Location', 'value' => 'Kochi'],
            ['label' => 'Stack', 'value' => 'Laravel'],
            ['label' => 'Status', 'value' => 'Open'],
        ],
        'cta_primary' => ['label' => 'Hire Me', 'href' => '#contact'],
        'cta_secondary' => ['label' => 'View Work', 'href' => '#projects'],
        'features' => [
            'Scalable Web Applications',
            'Modern Frontend Experiences',
            'Reliable Backend Systems',
            'End-to-End Product Delivery',
        ],
        'slides' => [
            [
                'src' => '/assets/images/portrait.png',
                'alt' => 'Guruprasad — full stack webdeveloper',
            ],
            [
                'src' => '/assets/images/about-team.jpg',
                'alt' => 'Team collaboration',
            ],
            [
                'src' => '/assets/images/about-collab.jpg',
                'alt' => 'Developers working together',
            ],
            [
                'src' => '/assets/images/portrait.png',
                'alt' => 'Guruprasad portrait',
            ],
        ],
        'active_slide' => 1,
    ],
    'what_we_do' => [
        'stats' => [
            [
                'label' => 'Delivery',
                'value' => '2wk',
                'sub' => 'Rapid Sprint Cycles',
                'icon' => 'bolt',
            ],
            [
                'label' => 'Architecture',
                'value' => 'API',
                'sub' => 'Scalable Systems',
                'icon' => 'chip',
            ],
            [
                'label' => 'Quality',
                'value' => 'Hi-Fi',
                'sub' => 'Clean Code Craft',
                'icon' => 'wave',
            ],
            [
                'label' => 'Support',
                'value' => '24/7',
                'sub' => 'Always Available',
                'icon' => 'battery',
            ],
            [
                'label' => 'Stack',
                'value' => 'Full',
                'sub' => 'End-To-End Build',
                'icon' => 'bluetooth',
            ],
        ],
        'frame' => [
            'code' => 'X1',
            'tagline' => 'Precision. Performance. Delivery.',
            'lottie' => '/assets/lottie/dev-agx.json',
            'lottie_alt' => 'Developer workspace animation',
        ],
        'eyebrow' => 'Technology',
        'heading' => 'Precision engineered for products.',
        'body' => 'Every build is shaped for speed, clarity, and long-term reliability — from Laravel backends and Node services to Electron apps and polished frontends that feel effortless to use.',
        'specs' => [
            [
                'label' => 'Backend',
                'title' => 'Laravel & PHP Systems',
                'detail' => 'Secure APIs, auth, and business logic built to scale.',
                'icon' => 'bolt',
            ],
            [
                'label' => 'Frontend',
                'title' => 'Modern UI Interfaces',
                'detail' => 'Responsive layouts with sharp typography and motion.',
                'icon' => 'chip',
            ],
            [
                'label' => 'Realtime',
                'title' => 'Node.js Services',
                'detail' => 'Fast APIs, tooling, and event-driven workflows.',
                'icon' => 'wave',
            ],
            [
                'label' => 'Desktop',
                'title' => 'Electron Applications',
                'detail' => 'Cross-platform apps with native feel and web power.',
                'icon' => 'battery',
            ],
            [
                'label' => 'Markup',
                'title' => 'Semantic HTML / CSS',
                'detail' => 'Accessible structure with production-ready styling.',
                'icon' => 'bluetooth',
            ],
            [
                'label' => 'Delivery',
                'title' => 'Sprint-Ready Shipping',
                'detail' => 'Clear milestones, demos, and reliable handoff.',
                'icon' => 'mic',
            ],
            [
                'label' => 'Support',
                'title' => 'Ongoing Iteration',
                'detail' => 'Improvements, fixes, and feature growth after launch.',
                'icon' => 'gamepad',
            ],
        ],
        'pillars' => [
            [
                'title' => 'Designed For Builders',
                'icon' => 'target',
            ],
            [
                'title' => 'Pro-Grade Performance',
                'icon' => 'gamepad',
            ],
            [
                'title' => 'Built To Last',
                'icon' => 'diamond',
            ],
            [
                'title' => 'Always On Support',
                'icon' => 'bolt',
            ],
        ],
    ],
    'work' => [
        'eyebrow' => 'Selected Work',
        'heading' => 'Work',
        'body' => 'A few builds that show how I ship — clear structure, sharp interfaces, and systems that hold up after launch.',
        'cta' => ['label' => 'Start a project', 'href' => '#contact'],
        'more' => [
            'label' => 'Want to see more?',
            'body' => 'These are selected highlights. Tell me about your product and I’ll share relevant case studies.',
            'button' => 'Contact for more',
            'href' => '#contact',
        ],
        'projects' => [
            [
                'code' => '01',
                'title' => 'Northline Commerce',
                'category' => 'Web App',
                'year' => '2025',
                'stack' => ['Laravel', 'PHP'],
                'href' => '#contact',
                'image' => '/assets/images/about-team.jpg',
                'image_alt' => 'Northline Commerce project',
            ],
            [
                'code' => '02',
                'title' => 'Pulse Ops Dashboard',
                'category' => 'Realtime',
                'year' => '2025',
                'stack' => ['Node.js', 'API'],
                'href' => '#contact',
                'image' => '/assets/images/about-collab.jpg',
                'image_alt' => 'Pulse Ops Dashboard project',
            ],
            [
                'code' => '03',
                'title' => 'Deskforge Studio',
                'category' => 'Desktop',
                'year' => '2024',
                'stack' => ['Electron', 'Node'],
                'href' => '#contact',
                'image' => '/assets/images/portrait.png',
                'image_alt' => 'Deskforge Studio project',
            ],
            [
                'code' => '04',
                'title' => 'Harbor Site',
                'category' => 'Website',
                'year' => '2024',
                'stack' => ['HTML', 'CSS'],
                'href' => '#contact',
                'image' => '/assets/images/about-team.jpg',
                'image_alt' => 'Harbor Marketing Site project',
            ],
            [
                'code' => '05',
                'title' => 'Ledger API Hub',
                'category' => 'Backend',
                'year' => '2024',
                'stack' => ['Laravel', 'API'],
                'href' => '#contact',
                'image' => '/assets/images/about-collab.jpg',
                'image_alt' => 'Ledger API Hub project',
            ],
            [
                'code' => '06',
                'title' => 'Kinetic Portfolio',
                'category' => 'Frontend',
                'year' => '2024',
                'stack' => ['JS', 'CSS'],
                'href' => '#contact',
                'image' => '/assets/images/portrait.png',
                'image_alt' => 'Kinetic Portfolio project',
            ],
            [
                'code' => '07',
                'title' => 'Relay Booking',
                'category' => 'Web App',
                'year' => '2023',
                'stack' => ['PHP', 'MySQL'],
                'href' => '#contact',
                'image' => '/assets/images/about-team.jpg',
                'image_alt' => 'Relay Booking project',
            ],
            [
                'code' => '08',
                'title' => 'Orbit Admin',
                'category' => 'Dashboard',
                'year' => '2023',
                'stack' => ['Node.js', 'UI'],
                'href' => '#contact',
                'image' => '/assets/images/about-collab.jpg',
                'image_alt' => 'Orbit Admin project',
            ],
        ],
    ],
    'ai_chat' => [
        'title' => 'Guru AI',
        'greeting' => 'Hi! I\'m Guru\'s AI assistant. Ask about web apps, my stack, or hiring Guruprasad.',
        'placeholder' => 'Ask me anything...',
        'model' => 'gpt-4o-mini',
        'system_prompt' => 'You are the friendly AI assistant on Guruprasad\'s portfolio (Guru). He is a freelance full stack webdeveloper in Kochi, Kerala. He builds web apps with Laravel, Node, PHP, Electron, and HTML/CSS. Keep replies concise (2-4 sentences), helpful, and professional. If asked to hire or discuss a project, suggest emailing hello@guru.dev.',
        'api_key' => getenv('OPENAI_API_KEY') ?: '',
    ],
    'contact' => [
        'eyebrow' => 'Contact',
        'heading_lead' => "Let's",
        'heading' => 'Talk',
        'body' => 'Have a product idea, rebuild, or ongoing build? Tell me what you\'re shipping — I\'ll reply with a clear next step.',
        'email_label' => 'Email',
        'details' => [
            ['label' => 'Location', 'value' => 'Kochi, Kerala'],
            ['label' => 'Status', 'value' => 'Open to work'],
            ['label' => 'Response', 'value' => 'Within 24h'],
        ],
        'form' => [
            'name_label' => 'Name',
            'name_placeholder' => 'Your name',
            'email_label' => 'Email',
            'email_placeholder' => 'you@company.com',
            'message_label' => 'Project',
            'message_placeholder' => 'What are you building?',
            'submit' => 'Send message',
            'success' => 'Thanks — I\'ll get back to you soon.',
            'error' => 'Something went wrong. Please email me directly.',
        ],
        'lottie' => '/assets/lottie/walking-business-woman.json',
        'lottie_alt' => 'Walking business woman animation',
    ],
    'footer' => [
        'tagline' => 'Full stack webdeveloper · Kochi, Kerala',
        'nav' => [
            ['label' => 'About', 'href' => '#about'],
            ['label' => 'Work', 'href' => '#projects'],
            ['label' => 'Stack', 'href' => '#what-we-do'],
            ['label' => 'Contact', 'href' => '#contact'],
        ],
        'social' => [
            ['label' => 'Email', 'href' => 'mailto:hello@guru.dev'],
            ['label' => 'LinkedIn', 'href' => 'https://linkedin.com'],
            ['label' => 'GitHub', 'href' => 'https://github.com'],
        ],
        'note' => 'Available for freelance and remote collaborations.',
    ],
];

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function asset(string $path): string
{
    global $config;

    return rtrim($config['site_url'], '/') . '/' . ltrim($path, '/');
}

function local_asset(string $path): string
{
    return '/' . ltrim($path, '/');
}
