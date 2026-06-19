<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_Bool;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_BoolTest extends TestCase
{

    public function test_constants(): void
    {
        $this->assertTrue(T_Bool::TRUE);
        $this->assertFalse(T_Bool::FALSE);
    }

    public function test_is_true(): void
    {
        $this->assertTrue(T_Bool::isTrue(true));
        $this->assertFalse(T_Bool::isTrue(false));
    }

    public function test_is_false(): void
    {
        $this->assertTrue(T_Bool::isFalse(false));
        $this->assertFalse(T_Bool::isFalse(true));
    }

    public function test_coerce_guards_boolean_ish_values(): void
    {
        $this->assertTrue(T_Bool::coerce(true));
        $this->assertTrue(T_Bool::coerce('yes'));
        $this->assertTrue(T_Bool::coerce('1'));
        $this->assertFalse(T_Bool::coerce('off'));
        $this->assertFalse(T_Bool::coerce('abc', false));   // never blind-cast to true
        $this->assertTrue(T_Bool::coerce('abc', true));     // -> default
        $this->assertNull(T_Bool::coerceOrNull('abc'));
        $this->assertTrue(T_Bool::coerceOrNull('true'));
        $this->assertFalse(T_Bool::coerceOrNull('no'));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_Bool::class))->isFinal());
    }

}
