<?php

// Opsi lain otomatis memakai default paket. Hanya penyesuaian portal ada di sini.
return [
    'title' => 'Portal Akademik',
    'title_postfix' => ' | Portal Akademik',
    'logo' => '<b>Portal</b> Akademik',
    'logo_img' => 'favicon.svg',
    'logo_img_alt' => 'Portal Akademik',
    'preloader' => ['enabled' => false],
    'use_route_url' => true,
    'dashboard_url' => 'dashboard',
    'login_url' => 'login',
    'logout_url' => 'logout',
    'register_url' => 'register',
    'password_reset_url' => 'password.request',
    'password_email_url' => 'password.email',
    'layout_fixed_sidebar' => true,
    'classes_sidebar' => 'bg-dark shadow',
    'sidebar_theme' => 'dark',
    'classes_brand_text' => 'fs-5',
    'classes_auth_card' => 'card-outline card-primary shadow-sm',
    'color_mode' => [
        'enabled' => true,
        'default' => 'light',
        'remember' => true,
        'no_flash_script' => true,
        'routes' => false,
    ],
    'menu' => [
        ['header' => 'BACKOFFICE AKADEMIK'],
        [
            'text' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'bi bi-grid-1x2',
            'can' => 'lihat dashboard',
        ],
        [
            'text' => 'Data Mahasiswa',
            'route' => 'admin.mahasiswa.index',
            'icon' => 'bi bi-mortarboard',
            'active' => ['admin/mahasiswa*'],
            'can' => 'lihat mahasiswa',
        ],
        ['header' => 'PORTAL'],
        ['text' => 'Beranda Publik', 'route' => 'home', 'icon' => 'bi bi-box-arrow-up-right'],
        ['type' => 'darkmode-widget', 'topnav_right' => true],
    ],
];
