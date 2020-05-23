<?php

namespace App\Providers;

use App\Auth\PassportSocialResolver;
use App\Helper;
use App\Providers\Macros\BluePrintMaxin;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
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

        LumenPassport::routes(
            $this->app->router,
            [
//            'prefix' => 'v1/oauth',
            ]
        );
        LumenPassport::tokensExpireIn(Carbon::now()->addMinutes(config('setting.api.token.access_token_expire')));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(config('setting.api.token.refresh_token_expire')));

        $this->app->bind(SocialUserResolverInterface::class, PassportSocialResolver::class);

        if ($this->app->runningInConsole()) {
            Blueprint::mixin(new BluePrintMaxin());
        }
    }
}
