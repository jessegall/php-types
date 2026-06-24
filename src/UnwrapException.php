<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

use RuntimeException;

/**
 * Thrown when a value is forced out of an empty {@see Option}.
 */
final class UnwrapException extends RuntimeException {}
