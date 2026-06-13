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

    public function test_class_is_final_and_cannot_be_instantiated(): void
    {
        $reflection = new ReflectionClass(T_Bool::class);
        $this->assertTrue($reflection->isFinal());
        $this->assertTrue($reflection->getConstructor()->isPrivate());
    }

}
