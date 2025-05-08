<?php

declare(strict_types=1);

use Flasher\Prime\Configuration;

return Configuration::from([
    'default' => 'flasher',

    'main_script' => '/vendor/flasher/flasher.min.js',

    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    'options' => [
        'timeout' => 5000,
        'position' => 'top-right',
    ],

    'inject_assets' => true,

    'translate' => true,

    'excluded_paths' => [],

    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    'presets' => [
        // AUTHENTICATION
        'auth_failed' => [
            'type' => 'error',
            'message' => 'Username atau kata sandi tidak sesuai.',
            'title' => 'Gagal',
        ],
        'auth_success' => [
            'type' => 'success',
            'message' => 'Selamat datang di point of sale.',
            'title' => 'Sukses',
        ],
        // CREATE DATA
        'create_success' => [
            'type' => 'success',
            'message' => 'Data berhasil disimpan.',
            'title' => 'Sukses',
        ],
        'create_failed' => [
            'type' => 'error',
            'message' => 'Data gagal disimpan.',
            'title' => 'Gagal'
        ],
        // UPDATE DATA
        'update_success' => [
            'type' => 'success',
            'message' => 'Data berhasil diubah.',
            'title' => 'Sukses'
        ],
        'update_failed' => [
            'type' => 'error',
            'message' => 'Data gagal diubah.',
            'title' => 'Gagal'
        ],
        // DELETE DATA
        'delete_success' => [
            'type' => 'success',
            'message' => 'Data berhasil dihapus.',
            'title' => 'Sukses'
        ],
        'delete_failed' => [
            'type' => 'error',
            'message' => 'Data gagal dihapus.',
            'title' => 'Gagal'
        ],
        // RESTORE DATA
        'restore_success' => [
            'type' => 'success',
            'message' => 'Data berhasil dikembalikan.',
            'title' => 'Sukses'
        ],
        'restore_failed' => [
            'type' => 'error',
            'message' => 'Data gagal dikembalikan.',
            'title' => 'Gagal'
        ],
    ]
]);
