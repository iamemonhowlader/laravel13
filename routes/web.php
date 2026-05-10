<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('admin.login'));

require __DIR__ . '/web/admin.php';
