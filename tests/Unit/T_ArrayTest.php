<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_Array;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_ArrayTest extends TestCase
{

    public function test_empty_constant_is_the_empty_array(): void
    {
        $this->assertSame([], T_Array::EMPTY);
    }

    public function test_empty_factory_returns_the_empty_array(): void
    {
        $this->assertSame([], T_Array::empty());
    }

    public function test_is_empty_is_true_for_the_empty_array(): void
    {
        $this->assertTrue(T_Array::isEmpty([]));
    }

    public function test_is_empty_is_false_for_a_populated_array(): void
    {
        $this->assertFalse(T_Array::isEmpty(['a']));
    }

    public function test_is_empty_treats_a_zero_element_as_non_empty(): void
    {
        $this->assertFalse(T_Array::isEmpty([0]));
    }

    public function test_is_not_empty_is_the_inverse(): void
    {
        $this->assertTrue(T_Array::isNotEmpty(['a']));
        $this->assertFalse(T_Array::isNotEmpty([]));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_Array::class))->isFinal());
    }

    public function test_class_cannot_be_instantiated(): void
    {
        $this->assertTrue((new ReflectionClass(T_Array::class))->getConstructor()->isPrivate());
    }

}
