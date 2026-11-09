<?php

return [
    // Tetap ditolak oleh controller di production meskipun flag ini true.
    'login_enabled' => env('DEMO_LOGIN_ENABLED', false),

    // Daftar tertutup: endpoint demo tidak menerima ID/email pengguna bebas.
    'accounts' => [
        'admin' => 'admin@akademik.test',
        'staf' => 'staf@akademik.test',
    ],
];
