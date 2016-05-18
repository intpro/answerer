<?php

namespace Interpro\Answerer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Bus\Dispatcher;

class AnswererServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        $this->publishes([__DIR__.'/Laravel/config/answerer.php' => config_path('answerer.php')]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Interpro\Answerer\Concept\AnswerListFactory',
            'Interpro\Answerer\Laravel\AnswerListFactory'
        );

        $this->app->singleton(
            'Interpro\Answerer\Concept\EncryptedLinkGenerator',
            'Interpro\Answerer\Laravel\EncryptedLinkGenerator'
        );

        $this->app->make('Interpro\Answerer\Laravel\Http\AnswererController');

        include __DIR__ . '/Laravel/Http/routes.php';

    }

}
