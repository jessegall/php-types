<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

use Illuminate\Support\ServiceProvider;

/**
 * The package ships pure static type helpers with nothing to bind — this
 * provider exists only so Laravel auto-discovery and Testbench have a target.
 */
final class PhpTypesServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }

}
