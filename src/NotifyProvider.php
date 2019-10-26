<?php

namespace Qklin\Notify;

use Qklin\Notify\Manager;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class NotifyProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 加载配置
        $this->app->configure(env('QKLIN_NOTIFY_CONFIG', 'notify'));

        if (!$this->app->bound('qklin.notify')) {
            $this->app->singleton('qklin.notify', function () {
                return new Manager();
            });
        }
    }
}
