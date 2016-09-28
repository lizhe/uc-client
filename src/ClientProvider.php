<?php

namespace Hsw\UcClient;

use Config;
use Validator;
use Route;
use Illuminate\Support\ServiceProvider;


class ClientProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/ucenter.php' => config_path('ucenter.php')
        ]);

        Route::any('api/' . Config::get('ucenter.apifilename'), \VergilLai\UcClient\Controller::class.'@api');

        Validator::extend('uc_username', '\\Hsw\\UcClient\\Validator@usernameValidate');
        Validator::extend('uc_email', '\\Hsw\\UcClient\\Validator@emailValidate');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('uc-client', function($app) {
            return new Client();
        });

        $this->app->bind('\\Hsw\\UcClient\\Contracts\\UcenterNoteApi', Config::get('ucenter.note_handler'));
    }
}
