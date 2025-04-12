<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\ScopeRepository;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind interfaces to concrete Passport classes
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(AccessTokenRepositoryInterface::class, AccessTokenRepository::class);
        $this->app->bind(ScopeRepositoryInterface::class, ScopeRepository::class);

        // Manually bind the AuthorizationServer to resolve private/public keys correctly
        $this->app->singleton(AuthorizationServer::class, function ($app) {
            return new AuthorizationServer(
                $app->make(ClientRepositoryInterface::class),
                $app->make(AccessTokenRepositoryInterface::class),
                $app->make(ScopeRepositoryInterface::class),
                new CryptKey(storage_path('oauth-private.key'), null, false),
                new CryptKey(storage_path('oauth-public.key'), null, false)
            );
        });

        // ✅ Manually bind the ResourceServer (fixes the unresolvable dependency error)
        $this->app->singleton(ResourceServer::class, function ($app) {
            return new ResourceServer(
                $app->make(AccessTokenRepositoryInterface::class),
                new CryptKey(storage_path('oauth-public.key'), null, false)
            );
        });
    }

    public function boot()
    {
        //
    }
}