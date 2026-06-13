<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the null check — `$x === null` with intent-revealing predicates.
 */
final class T_Null
{

    /**
     * Whether the value is null.
     *
     * @phpstan-assert-if-true null $value
     * @phpstan-assert-if-false !null $value
     */
    public static function isNull(mixed $value): bool
    {
        return $value === null;
    }

    /**
     * Whether the value is anything but null.
     *
     * @phpstan-assert-if-true !null $value
     * @phpstan-assert-if-false null $value
     */
    public static function isNotNull(mixed $value): bool
    {
        return ! self::isNull($value);
    }

}
