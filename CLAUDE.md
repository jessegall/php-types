# Guide for Claude / AI agents working in this repo

This is **php-types** — a tiny, zero-dependency runtime package that gives
**names to magic literals**. Instead of scattering `''`, `[]`, `'{}'`, `0`,
`true`, and `null` (and re-checking them defensively everywhere), code reaches
for `T_String::empty()`, `T_String::isEmpty($x)`, `T_Json::emptyObject()`, etc.
Each type class is a `final`, non-instantiable static holder of a constant, an
optional factory, and intent-revealing predicates.

## The classes

`src/T_String.php`, `T_Array.php`, `T_Json.php`, `T_Int.php`, `T_Float.php`,
`T_Bool.php`, `T_Null.php`. The `T_` prefix is deliberate: `String` and `Array`
are reserved words, and the prefix reads as "Type". `PhpTypesServiceProvider` is
an intentional no-op — it binds nothing and exists only so Laravel
auto-discovery and Testbench have a target.

## Code style (match it exactly)

- `declare(strict_types=1);` at the top of every file. This is a *types*
  package — predicates intentionally do not coerce (`T_Float::isZero(int)`
  errors under strict types, which is correct).
- **Allman braces**: opening `{` on its own line.
- One blank line after the class opening brace.
- Classes are `final` and hold only static members (no constructor).
- 4-space indentation.
- `T_Float` predicates are **exact comparisons** (no epsilon) — keep them that
  way and keep the caveat in the docblock.
- `T_Json::isEmptyObject` / `isEmptyArray` are **semantic** — they `json_decode`
  and inspect the result, so whitespace variants like `'{ }'` count as empty.
  Keep them decode-based, not textual.

## Quick commands

```bash
composer test          # purge testbench skeleton, then run phpunit
vendor/bin/phpunit     # run the suite directly
```

## Commit / release conventions for this repo

- Commit messages: **no `Co-Authored-By` trailer** — neither in commits nor in
  pull request bodies.
- Every commit gets a new semver tag: **patch** for small edits / bug fixes,
  **minor** for new types or methods. **Never bump major** — ask the user first.
- Push the commit and its new tag on the same action (once a remote exists).
