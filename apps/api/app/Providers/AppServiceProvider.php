<?php

namespace App\Providers;

use App\Support\EnvValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            EnvValidator::validate();
        }
    }
}
