<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\ArrayBuilder;
use JesseGall\PhpTypes\T_Array;
use JesseGall\PhpTypes\Tests\TestCase;

class ArrayBuilderTest extends TestCase
{

    public function test_from_seeds_the_builder(): void
    {
        $this->assertSame(['a' => 1], ArrayBuilder::from(['a' => 1])->toArray());
    }

    public function test_t_array_from_returns_a_builder(): void
    {
        $this->assertInstanceOf(ArrayBuilder::class, T_Array::from(['a' => 1]));
        $this->assertSame(['a' => 1], T_Array::from(['a' => 1])->toArray());
    }

    public function test_from_defaults_to_empty(): void
    {
        $this->assertSame([], ArrayBuilder::from()->toArray());
        $this->assertSame([], T_Array::from()->toArray());
    }

    public function test_put_always_sets(): void
    {
        $this->assertSame(['a' => 1, 'b' => 2], T_Array::from(['a' => 1])->put('b', 2)->toArray());
    }

    public function test_put_when_true_sets(): void
    {
        $this->assertSame(['a' => 1, 'b' => 2], T_Array::from(['a' => 1])->putWhen(true, 'b', 2)->toArray());
    }

    public function test_put_when_false_skips(): void
    {
        $this->assertSame(['a' => 1], T_Array::from(['a' => 1])->putWhen(false, 'b', 2)->toArray());
    }

    public function test_put_unless_null_keeps_non_null(): void
    {
        $this->assertSame(['label' => 'x'], T_Array::from()->putUnlessNull('label', 'x')->toArray());
    }

    public function test_put_unless_null_skips_null(): void
    {
        $this->assertSame([], T_Array::from()->putUnlessNull('label', null)->toArray());
    }

    public function test_put_unless_null_keeps_falsey_non_null(): void
    {
        // 0 / false / '' are real values — only NULL is skipped.
        $this->assertSame(['a' => 0, 'b' => false, 'c' => ''], T_Array::from()
            ->putUnlessNull('a', 0)
            ->putUnlessNull('b', false)
            ->putUnlessNull('c', '')
            ->toArray());
    }

    public function test_put_unless_empty_skips_null_empty_array_and_empty_string(): void
    {
        $this->assertSame([], T_Array::from()
            ->putUnlessEmpty('a', null)
            ->putUnlessEmpty('b', [])
            ->putUnlessEmpty('c', '')
            ->toArray());
    }

    public function test_put_unless_empty_keeps_zero_and_false(): void
    {
        // Unlike array_filter, a real 0 / false / '0' survives — this guards
        // key presence, not truthiness.
        $this->assertSame(['a' => 0, 'b' => false, 'c' => '0'], T_Array::from()
            ->putUnlessEmpty('a', 0)
            ->putUnlessEmpty('b', false)
            ->putUnlessEmpty('c', '0')
            ->toArray());
    }

    public function test_put_unless_empty_keeps_non_empty_array(): void
    {
        $this->assertSame(['opts' => ['x']], T_Array::from()->putUnlessEmpty('opts', ['x'])->toArray());
    }

    public function test_a_realistic_conditional_shape(): void
    {
        $build = fn (?string $label, array $options, bool $visible): array => T_Array::from([
            'name' => 'port',
            'type' => 'string',
        ])
            ->putUnlessNull('label', $label)
            ->putUnlessEmpty('options', $options)
            ->putWhen($visible, 'visible', true)
            ->toArray();

        $this->assertSame(['name' => 'port', 'type' => 'string'], $build(null, [], false));
        $this->assertSame(
            ['name' => 'port', 'type' => 'string', 'label' => 'Port', 'options' => ['a'], 'visible' => true],
            $build('Port', ['a'], true),
        );
    }

    public function test_later_put_overwrites_earlier(): void
    {
        $this->assertSame(['a' => 2], T_Array::from(['a' => 1])->put('a', 2)->toArray());
    }

}
