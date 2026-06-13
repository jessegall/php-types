<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_Float;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_FloatTest extends TestCase
{

    public function test_zero_constant_and_factory(): void
    {
        $this->assertSame(0.0, T_Float::ZERO);
        $this->assertSame(0.0, T_Float::zero());
    }

    public function test_is_zero_is_true_for_zero(): void
    {
        $this->assertTrue(T_Float::isZero(0.0));
    }

    public function test_is_zero_is_false_for_non_zero(): void
    {
        $this->assertFalse(T_Float::isZero(0.1));
        $this->assertFalse(T_Float::isZero(-0.1));
    }

    public function test_is_not_zero_is_the_inverse(): void
    {
        $this->assertTrue(T_Float::isNotZero(3.14));
        $this->assertFalse(T_Float::isNotZero(0.0));
    }

    public function test_class_is_final_and_cannot_be_instantiated(): void
    {
        $reflection = new ReflectionClass(T_Float::class);
        $this->assertTrue($reflection->isFinal());
        $this->assertTrue($reflection->getConstructor()->isPrivate());
    }

}
