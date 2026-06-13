<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T_Json;
use JesseGall\PhpTypes\Tests\TestCase;
use ReflectionClass;

class T_JsonTest extends TestCase
{

    public function test_empty_object_constant_and_factory(): void
    {
        $this->assertSame('{}', T_Json::EMPTY_OBJECT);
        $this->assertSame('{}', T_Json::emptyObject());
    }

    public function test_empty_array_constant_and_factory(): void
    {
        $this->assertSame('[]', T_Json::EMPTY_ARRAY);
        $this->assertSame('[]', T_Json::emptyArray());
    }

    public function test_is_empty_object_is_true_for_the_exact_literal(): void
    {
        $this->assertTrue(T_Json::isEmptyObject('{}'));
    }

    public function test_is_empty_object_is_false_for_whitespace_variants(): void
    {
        $this->assertFalse(T_Json::isEmptyObject('{ }'));
        $this->assertFalse(T_Json::isEmptyObject("{}\n"));
    }

    public function test_is_empty_object_is_false_for_the_empty_array_literal(): void
    {
        $this->assertFalse(T_Json::isEmptyObject('[]'));
    }

    public function test_is_empty_object_is_false_for_a_populated_object(): void
    {
        $this->assertFalse(T_Json::isEmptyObject('{"a":1}'));
    }

    public function test_is_empty_array_is_true_for_the_exact_literal(): void
    {
        $this->assertTrue(T_Json::isEmptyArray('[]'));
    }

    public function test_is_empty_array_is_false_for_whitespace_and_other_literals(): void
    {
        $this->assertFalse(T_Json::isEmptyArray('[ ]'));
        $this->assertFalse(T_Json::isEmptyArray('{}'));
        $this->assertFalse(T_Json::isEmptyArray('[1]'));
    }

    public function test_class_is_final_and_cannot_be_instantiated(): void
    {
        $reflection = new ReflectionClass(T_Json::class);
        $this->assertTrue($reflection->isFinal());
        $this->assertTrue($reflection->getConstructor()->isPrivate());
    }

}
