<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Daycode\Curtain\Http\Controllers\PreviewController;

Route::get('curtain/preview', [PreviewController::class, 'show'])
    ->name('curtain.preview')
    ->middleware(['web', 'signed']);
