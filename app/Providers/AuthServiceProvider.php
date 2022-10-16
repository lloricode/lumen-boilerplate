<?php

declare(strict_types=1);

namespace App\Providers;

use App\Auth\PassportSocialResolver;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(SocialUserResolverInterface::class, PassportSocialResolver::class);
    }
}
