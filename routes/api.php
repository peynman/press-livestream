<?php

use Illuminate\Support\Facades\Route;
use Larapress\LiveStream\Services\LiveStream\LiveStreamController;

// api routes with public access
Route::middleware(config('larapress.pages.middleware'))
    ->group(function () {
        LiveStreamController::registerPublicApiRoutes();
    });
