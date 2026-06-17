<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * A fluent assembler for arrays whose shape is partly conditional.
 *
 * Replaces the "spread a ternary whose other arm is an empty array" idiom —
 *
 *     [
 *         'name' => $x,
 *         ...($cond ? ['label' => $label] : T_Array::empty()),
 *         ...($options === [] ? T_Array::empty() : ['options' => $options]),
 *     ]
 *
 * — which buries which keys are conditional, flips the ternary direction at
 * random, and (when written as `$out['label'] = …`) reads as array-bag
 * indexing. Seed the builder from the always-present keys, then add the
 * conditional ones as named guards:
 *
 *     T_Array::from([
 *         'name' => $x,
 *     ])
 *         ->putUnlessNull('label', $label)
 *         ->putUnlessEmpty('options', $options)
 *         ->putWhen($flag, 'visible', true)
 *         ->toArray();
 *
 * @template TKey of array-key
 * @template TValue
 */
final class ArrayBuilder
{

    /**
     * @param  array<TKey, TValue>  $items
     */
    private function __construct(private array $items) {}

    /**
     * Start a builder seeded with the always-present keys.
     *
     * @param  array<TKey, TValue>  $items
     * @return self<TKey, TValue>
     */
    public static function from(array $items = T_Array::EMPTY): self
    {
        return new self($items);
    }

    /**
     * Always set $key to $value.
     *
     * @param  TKey  $key
     * @param  TValue  $value
     * @return self<TKey, TValue>
     */
    public function put(int|string $key, mixed $value): self
    {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * Set $key only when $condition holds.
     *
     * @param  TKey  $key
     * @param  TValue  $value
     * @return self<TKey, TValue>
     */
    public function putWhen(bool $condition, int|string $key, mixed $value): self
    {
        return $condition ? $this->put($key, $value) : $this;
    }

    /**
     * Set $key unless $value is null.
     *
     * @param  TKey  $key
     * @param  TValue  $value
     * @return self<TKey, TValue>
     */
    public function putUnlessNull(int|string $key, mixed $value): self
    {
        return $value === null ? $this : $this->put($key, $value);
    }

    /**
     * Set $key unless $value is "empty" — null, `[]`, or `''`. A `0`, `0.0`,
     * or `false` is a real value and IS kept (unlike `array_filter`), because
     * this guards key PRESENCE, not value truthiness.
     *
     * @param  TKey  $key
     * @param  TValue  $value
     * @return self<TKey, TValue>
     */
    public function putUnlessEmpty(int|string $key, mixed $value): self
    {
        if ($value === null || $value === [] || $value === '') {
            return $this;
        }

        return $this->put($key, $value);
    }

    /**
     * The assembled array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

}
