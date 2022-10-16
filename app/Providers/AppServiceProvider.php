<?php

declare(strict_types=1);

namespace App\Providers;

use App\Helper;
use App\Providers\Macros\BluePrintMaxin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Schema;
use ReflectionException;

class AppServiceProvider extends ServiceProvider
{
    /** @throws ReflectionException */
    public function register()
    {
        if ( ! Helper::isLatestMysqlVersion()) {
            Schema::defaultStringLength(191);
        }

        if ($this->app->runningInConsole()) {
            Blueprint::mixin(new BluePrintMaxin());
        }
    }
}
