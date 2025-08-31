<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Blink;
use Statamic\Facades\Entry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Entry::query()
            ->where('collection', 'theatres')
            ->get()
            ->each(function ($entry) {
                // Blink::forget("entry-{$entry->id()}-blueprint");
            });
    }
}
