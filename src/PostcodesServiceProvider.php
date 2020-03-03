<?php

declare(strict_types=1);

namespace JustSteveKing\LaravelPostcodes;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;

class PostcodesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/services.php',
            'services'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/postcodes.php',
            'postcodes'
        );

        $this->app->bind(PostcodeService::class, function () {
            return new PostcodeService(
                new Client()
            );
        });

        \Illuminate\Validation\Rule::macro('postcode', function () {
            return new \JustSteveKing\LaravelPostcodes\Rules\Postcode(resolve(PostcodeService::class));
        });
    }

    public function boot()
    {
        //
    }
}
