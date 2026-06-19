<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_Int;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_IntTest extends TestCase
{

    public function test_zero_constant_and_factory(): void
    {
        $this->assertSame(0, T_Int::ZERO);
        $this->assertSame(0, T_Int::zero());
    }

    public function test_one_and_minus_one_constants(): void
    {
        $this->assertSame(1, T_Int::ONE);
        $this->assertSame(-1, T_Int::MINUS_ONE);
    }

    public function test_is_zero_is_true_for_zero(): void
    {
        $this->assertTrue(T_Int::isZero(0));
    }

    public function test_is_zero_is_false_for_non_zero(): void
    {
        $this->assertFalse(T_Int::isZero(1));
        $this->assertFalse(T_Int::isZero(-1));
    }

    public function test_is_not_zero_is_the_inverse(): void
    {
        $this->assertTrue(T_Int::isNotZero(5));
        $this->assertFalse(T_Int::isNotZero(0));
    }

    public function test_coerce_guards_numeric_and_never_masks_garbage(): void
    {
        $this->assertSame(42, T_Int::coerce('42'));
        $this->assertSame(42, T_Int::coerce(42));
        $this->assertSame(9, T_Int::coerce('abc', 9));   // never 0
        $this->assertSame(9, T_Int::coerce([], 9));
        $this->assertSame(9, T_Int::coerce(null, 9));
        $this->assertNull(T_Int::coerceOrNull('abc'));
        $this->assertSame(7, T_Int::coerceOrNull('7'));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_Int::class))->isFinal());
    }

}
