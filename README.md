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
| `T_String` | `EMPTY`, `SPACE` | `empty()` | `isEmpty()`, `isNotEmpty()`, `isBlank()`, `isNotBlank()` |
| `T_Array` | `EMPTY`, `MATRIX` | `empty()`, `matrix()` | `isEmpty()`, `isNotEmpty()` |
| `T_Json` | `EMPTY_OBJECT`, `EMPTY_ARRAY` | `emptyObject()`, `emptyArray()` | `isEmptyObject()`, `isEmptyArray()` |
| `T_Int` | `ZERO` | `zero()` | `isZero()`, `isNotZero()` |
| `T_Float` | `ZERO` | `zero()` | `isZero()`, `isNotZero()` |
| `T_Bool` | `TRUE`, `FALSE` | — | `isTrue()`, `isFalse()` |
| `T_Null` | — | — | `isNull()`, `isNotNull()` |

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
