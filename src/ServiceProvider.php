<?php
declare(strict_types=1);

namespace Yokuru\Chatwork;

use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/chatwork.php' => config_path('chatwork.php'),
        ]);
    }
}