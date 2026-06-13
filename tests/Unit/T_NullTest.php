<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_Null;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_NullTest extends TestCase
{

    public function test_is_null_is_true_for_null(): void
    {
        $this->assertTrue(T_Null::isNull(null));
    }

    public function test_is_null_is_false_for_falsy_non_null_values(): void
    {
        $this->assertFalse(T_Null::isNull(0));
        $this->assertFalse(T_Null::isNull(''));
        $this->assertFalse(T_Null::isNull(false));
        $this->assertFalse(T_Null::isNull([]));
    }

    public function test_is_not_null_is_the_inverse(): void
    {
        $this->assertTrue(T_Null::isNotNull('x'));
        $this->assertFalse(T_Null::isNotNull(null));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_Null::class))->isFinal());
    }

}
