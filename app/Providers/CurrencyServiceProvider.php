<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repository\CurrencyInterface;
use App\Repository\CurrencyRepository;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            CurrencyInterface::class,
            CurrencyRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
