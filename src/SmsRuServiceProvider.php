<?php

namespace NotificationChannels\SmsRu;

use Illuminate\Support\ServiceProvider;

class SmsRuServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SmsRuApi::class, function () {
            $config = config('services.sms-ru');

            return new SmsRuApi($config['api_id'], $config['sender']);
        });
    }
}
