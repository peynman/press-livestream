<?php

namespace Larapress\LiveStream\Services\LiveStream;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Larapress\CRUD\Exceptions\AppException;

/**
 * Controller for Live Streaming management.
 *
 * @group Live Stream
 */
class LiveStreamController extends Controller
{
    public static function registerPublicApiRoutes()
    {
        Route::any('live-stream/auth', '\\' . self::class . '@onAuthenticate')
            ->name('live-stream.any.atuh')
            ->middleware([
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
            ]);

        Route::any('live-stream/on-publish', '\\' . self::class . '@onPublish')
            ->name('live-stream.any.on-publish');
        Route::any('live-stream/on-update', '\\' . self::class . '@onUpdate')
            ->name('live-stream.any.on-update');
        Route::any('live-stream/on-publish-done', '\\' . self::class . '@onPublishDone')
            ->name('live-stream.any.on-publish-done');
        Route::any('live-stream/on-done', '\\' . self::class . '@onDone')
            ->name('live-stream.any.on-done');
    }


    /**
     * Authenticate watch access
     *
     * @param Request $request
     *
     * @return Response
     */
    public function onAuthenticate(ILiveStreamService $service, Request $request)
    {
        if (!$service->canWatchLiveStream($request)) {
            throw new AppException(AppException::ERR_OBJ_ACCESS_DENIED);
        }

        return response('ok');
    }

    /**
     * Authenticate publish access
     *
     * @param Request $request
     *
     * @return Response
     */
    public function onPublish(ILiveStreamService $service, Request $request)
    {
        if (!$service->canStartLiveStream($request)) {
            throw new AppException(AppException::ERR_OBJ_ACCESS_DENIED);
        }
        return $service->liveStreamStarted($request);
    }

    /**
     * Publish done event
     *
     * @param Request $request
     */
    public function onPublishDone(ILiveStreamService $service, Request $request)
    {
        return $service->liveStreamEnded($request);
    }

    /**
     * Publish update event
     *
     * @param Request $request
     */
    public function onUpdate(Request $request)
    {
        return response();
    }

    /**
     * Done event
     *
     * @param Request $request
     */
    public function onDone(Request $request)
    {
        return response();
    }
}
