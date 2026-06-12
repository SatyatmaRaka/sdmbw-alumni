<?php

/**
 * config/production.php
 *
 * File ini BUKAN tempat menyimpan konfigurasi production.
 * Semua konfigurasi production diatur melalui file .env di server cPanel,
 * bukan melalui file ini.
 *
 * File ini hanya berfungsi sebagai dokumentasi untuk developer berikutnya.
 *
 * Untuk deploy ke cPanel:
 * 1. Salin file .env.production ke server sebagai .env
 * 2. Isi semua nilai yang bertanda "# WAJIB DIISI"
 * 3. Jalankan: php artisan key:generate
 * 4. Jalankan: php artisan migrate --force
 * 5. Jalankan: php artisan storage:link
 * 6. Pastikan QUEUE_CONNECTION=sync (tidak perlu queue worker)
 *
 * @see .env.production — template konfigurasi environment production
 */

return [];
