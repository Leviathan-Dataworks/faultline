<?php

namespace Leviathandataworks\Faultline\Providers;

use Illuminate\Support\ServiceProvider;

final class FaultlineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/faultline.php' => config_path('faultline.php'),
        ]);
    }
}
