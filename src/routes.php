<?php

declare(strict_types=1);

use Daycode\Curtain\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::get('curtain/preview', [PreviewController::class, 'show'])
    ->name('curtain.preview')
    ->middleware(['web', 'signed']);
