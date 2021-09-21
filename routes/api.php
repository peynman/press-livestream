<?php

use Illuminate\Support\Facades\Route;
use Larapress\LiveStream\Services\LiveStream\LiveStreamController;

// api routes with public access
Route::middleware(config('larapress.crud.public-middlewares'))
    ->prefix(config('larapress.crud.prefix'))
    ->group(function () {
        LiveStreamController::registerPublicApiRoutes();
    });
