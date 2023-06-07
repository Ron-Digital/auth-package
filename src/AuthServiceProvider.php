<?php

namespace Rondigital\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
{
    // Bu metot, paket yapılandırma dosyasını uygulama yapılandırma dosyasıyla birleştirecektir.
    // Eğer uygulama yapılandırma dosyasında belirli bir ayar yoksa, paket yapılandırma dosyasından bu ayarları alır.
    $this->mergeConfigFrom(
        __DIR__.'./config/authservice.php', 'authservice'
    );

    // Bu metot, uygulama sahibinin paket yapılandırma dosyasını kendi yapılandırma dosyasına yayınlamasına izin verir.
    $this->publishes([
        __DIR__.'./config/authservice.php' => $this->app->configPath('authservice.php'),
    ]);
}    

}
