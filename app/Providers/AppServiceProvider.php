<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Request $request): void
    {
        if ($request->server->get('HTTP_X_FORWARDED_PROTO') === 'https' || 
            $request->server->get('HTTP_CF_VISITOR') === '{"scheme":"https"}') {
            $this->app['url']->forceScheme('https');
        }
    }
}