<?php

namespace App\Providers;

use App\Contracts\ExpressionParserInterface;
use App\Parsers\BasicExpressionParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExpressionParserInterface::class, BasicExpressionParser::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
