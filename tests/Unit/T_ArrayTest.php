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

    public function test_matrix_is_a_nested_array_with_one_empty_inner_array(): void
    {
        $this->assertSame([[]], T_Array::MATRIX);
        $this->assertSame([[]], T_Array::matrix());
    }

    public function test_coalesce_for_returns_the_value_at_the_key(): void
    {
        $this->assertSame(['a', 'b'], T_Array::coalesceFor(['x' => ['a', 'b']], 'x'));
    }

    public function test_coalesce_for_returns_the_empty_default_when_key_is_absent(): void
    {
        $this->assertSame([], T_Array::coalesceFor(['x' => ['a']], 'missing'));
    }

    public function test_coalesce_for_returns_the_empty_default_when_value_is_null(): void
    {
        $this->assertSame([], T_Array::coalesceFor(['x' => null], 'x'));
    }

    public function test_coalesce_for_uses_the_given_default(): void
    {
        $this->assertSame(['fallback'], T_Array::coalesceFor([], 'x', ['fallback']));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_Array::class))->isFinal());
    }

}
