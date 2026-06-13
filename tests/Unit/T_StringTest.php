<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_String;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_StringTest extends TestCase
{

    public function test_empty_constant_is_the_empty_string(): void
    {
        $this->assertSame('', T_String::EMPTY);
    }

    public function test_empty_factory_returns_the_empty_string(): void
    {
        $this->assertSame('', T_String::empty());
    }

    public function test_is_empty_is_true_for_the_empty_string(): void
    {
        $this->assertTrue(T_String::isEmpty(''));
    }

    public function test_is_empty_is_false_for_a_non_empty_string(): void
    {
        $this->assertFalse(T_String::isEmpty('a'));
    }

    public function test_is_empty_treats_whitespace_as_non_empty(): void
    {
        $this->assertFalse(T_String::isEmpty(' '));
    }

    public function test_is_empty_treats_zero_string_as_non_empty(): void
    {
        $this->assertFalse(T_String::isEmpty('0'));
    }

    public function test_is_not_empty_is_the_inverse(): void
    {
        $this->assertTrue(T_String::isNotEmpty('a'));
        $this->assertFalse(T_String::isNotEmpty(''));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_String::class))->isFinal());
    }

}
