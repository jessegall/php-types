<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use Closure;
use JesseGall\PhpTypes\Defaults;
use JesseGall\PhpTypes\Tests\TestCase;

class DefaultsTest extends TestCase
{

    public function test_each_factory_returns_a_closure(): void
    {
        $this->assertInstanceOf(Closure::class, Defaults::array());
        $this->assertInstanceOf(Closure::class, Defaults::string());
        $this->assertInstanceOf(Closure::class, Defaults::int());
        $this->assertInstanceOf(Closure::class, Defaults::float());
        $this->assertInstanceOf(Closure::class, Defaults::bool());
        $this->assertInstanceOf(Closure::class, Defaults::null());
    }

    public function test_factories_produce_the_named_defaults(): void
    {
        $this->assertSame([], (Defaults::array())());
        $this->assertSame('', (Defaults::string())());
        $this->assertSame(0, (Defaults::int())());
        $this->assertSame(0.0, (Defaults::float())());
        $this->assertFalse((Defaults::bool())());
        $this->assertNull((Defaults::null())());
    }

    public function test_factories_are_zero_argument_callables(): void
    {
        // Usable wherever a deferred default is wanted, e.g. array_map seeds or
        // resolver `->then(...)` factories.
        $make = Defaults::array();

        $this->assertSame([[], [], []], array_map(static fn () => $make(), [1, 2, 3]));
    }

}
