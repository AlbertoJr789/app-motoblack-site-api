<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('active', function(){
            return $this->whereActive(true);
        });
        Builder::macro('unactive', function(){
            return $this->whereActive(false);
        });

        if ($this->app->runningInConsole()) {
            return;
        }
 
        $lang = request()->getPreferredLanguage() ?? 'pt_BR';
        Cache::remember('translationsJSON'.$lang, now()->addHour(1), function () use ($lang) {
            try {
                $contents = file_get_contents("../lang/$lang.json"); 
            } catch (\Throwable $th) {
                $contents = file_get_contents("lang/$lang.json"); 
            }
            return $contents;
        });

    }
}
