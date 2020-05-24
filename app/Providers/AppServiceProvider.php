<?php

namespace App\Providers;

use App\Auth\PassportSocialResolver;
use App\Helper;
use App\Providers\Macros\BluePrintMaxin;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @throws \ReflectionException
     */
    public function register()
    {
        if (!Helper::isLatestMysqlVersion()) {
            Schema::defaultStringLength(191);
        }

        Passport::hashClientSecrets();
        LumenPassport::routes(
            $this->app->router,
            [
//            'prefix' => 'v1/oauth',
                'middleware' => 'throttle:30,30',
            ]
        );
        LumenPassport::tokensExpireIn(Date::now()->addMinutes(config('setting.api.token.access_token_expire')));
        Passport::refreshTokensExpireIn(Date::now()->addMinutes(config('setting.api.token.refresh_token_expire')));

        $this->app->bind(SocialUserResolverInterface::class, PassportSocialResolver::class);

        if ($this->app->runningInConsole()) {
            Blueprint::mixin(new BluePrintMaxin());
        }
    }
}
