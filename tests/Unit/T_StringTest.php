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

    public function test_space_constant_is_a_single_space(): void
    {
        $this->assertSame(' ', T_String::SPACE);
    }

    public function test_whitespace_and_control_constants(): void
    {
        $this->assertSame("\n", T_String::NEWLINE);
        $this->assertSame("\n\n", T_String::PARAGRAPH);
        $this->assertSame("\r", T_String::CARRIAGE_RETURN);
        $this->assertSame("\r\n", T_String::CRLF);
        $this->assertSame("\t", T_String::TAB);
        $this->assertSame("\0", T_String::NULL_BYTE);
    }

    public function test_separator_constants(): void
    {
        $this->assertSame(',', T_String::COMMA);
        $this->assertSame(', ', T_String::COMMA_SPACE);
        $this->assertSame('/', T_String::SLASH);
        $this->assertSame('.', T_String::DOT);
        $this->assertSame('-', T_String::DASH);
    }

    public function test_is_blank_is_true_for_empty_and_whitespace(): void
    {
        $this->assertTrue(T_String::isBlank(''));
        $this->assertTrue(T_String::isBlank(' '));
        $this->assertTrue(T_String::isBlank("\t\n  "));
    }

    public function test_is_blank_is_false_for_any_visible_character(): void
    {
        $this->assertFalse(T_String::isBlank('a'));
        $this->assertFalse(T_String::isBlank('  x  '));
        $this->assertFalse(T_String::isBlank('0'));
    }

    public function test_is_not_blank_is_the_inverse(): void
    {
        $this->assertTrue(T_String::isNotBlank('a'));
        $this->assertFalse(T_String::isNotBlank('   '));
    }

    public function test_coalesce_returns_value_or_empty_default(): void
    {
        $this->assertSame('x', T_String::coalesce('x'));
        $this->assertSame('', T_String::coalesce(null));
    }

    public function test_coalesce_uses_given_default_when_null(): void
    {
        $this->assertSame(',', T_String::coalesce(null, T_String::COMMA));
        $this->assertSame('x', T_String::coalesce('x', T_String::COMMA));
        $this->assertSame('fallback', T_String::coalesce(null, 'fallback'));
    }

    public function test_class_is_final(): void
    {
        $this->assertTrue((new ReflectionClass(T_String::class))->isFinal());
    }

}
