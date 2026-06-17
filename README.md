# php-types

Named typed constants and predicates — give meaning to magic literals.

A raw `''`, `[]`, `'{}'`, `0`, `true`, or `null` carries an unstated intent and
gets re-checked defensively all over a codebase (`if ($this->delimiter === '')`).
These tiny static classes give that intent a name and the check a single home.

```php
use JesseGall\PhpTypes\T_String;

$prefix = T_String::empty();              // '' with a name
if (T_String::isEmpty($delimiter)) { … }  // reads as intent

// as a first-class callable
$nonEmpty = array_filter($parts, T_String::isNotEmpty(...));
```

## Types

| Class | Constant(s) | Factory | Predicates |
|---|---|---|---|
| `T_String` | `EMPTY`, `SPACE`, `NEWLINE`, `PARAGRAPH`, `CARRIAGE_RETURN`, `CRLF`, `TAB`, `NULL_BYTE`, `COMMA`, `COMMA_SPACE`, `SLASH`, `DOT`, `DASH` | `empty()` | `isEmpty()`, `isNotEmpty()`, `isBlank()`, `isNotBlank()` |
| `T_Array` | `EMPTY`, `MATRIX` | `empty()`, `matrix()` | `isEmpty()`, `isNotEmpty()` |
| `T_Json` | `EMPTY_OBJECT`, `EMPTY_ARRAY` | `emptyObject()`, `emptyArray()` | `isEmptyObject()`, `isEmptyArray()` |
| `T_Int` | `ZERO`, `ONE`, `MINUS_ONE` | `zero()` | `isZero()`, `isNotZero()` |
| `T_Float` | `ZERO` | `zero()` | `isZero()`, `isNotZero()` |
| `T_Bool` | `TRUE`, `FALSE` | — | `isTrue()`, `isFalse()` |
| `T_Null` | — | — | `isNull()`, `isNotNull()` |

## Deferred defaults

`Defaults` returns a zero-argument `Closure` that produces a type's default —
for when a place wants a *callable* yielding the default rather than the value:

```php
$make = Defaults::array();   // Closure(): array{}
$make();                     // []

// e.g. a resolver factory or a lazy fallback:
IsNull::make()->then(Defaults::array());
```

`Defaults::array()`, `string()`, `int()`, `float()`, `bool()` (`false`), `null()`.
For the value directly, use the type's own accessor (`T_Array::empty()`, …).

`T_Json` predicates are semantic — `isEmptyObject('{ }')` and `isEmptyObject("{\n}")`
are `true` (they decode to an empty object), while `isEmptyObject('[]')` and
invalid JSON are `false`.

## Install

```bash
composer require jessegall/php-types
```

Requires PHP 8.2+. Zero runtime dependencies.

## Test

```bash
composer test
```
