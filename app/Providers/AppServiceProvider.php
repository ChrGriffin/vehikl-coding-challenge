<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Events\CommandStarting;
use App\Entities\Ticket;
use Illuminate\Filesystem\Filesystem;
use Event, Storage, Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // delete barcode images when running a fresh migration
        Event::listen(CommandStarting::class, function ($event) {
            if($event->command === 'migrate:fresh') {
                (new Filesystem)->cleanDirectory(storage_path('app/public/barcodes'));
            }
        });
    }
}
