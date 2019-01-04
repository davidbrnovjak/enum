<?php declare(strict_types=1);

/**
 * Contains all exceptions used in project.
 *
 * - Usage exceptions: leads directly to fix by programmer. They are never caught and should never happen on production.
 * - Runtime exception: they represent valid case in domain logic. They should be handled at runtime and caught.
 *     Therefore every error should have separate exception type.
 */

namespace Grifart\Enum;

// Project root exceptions:
final class UsageException extends \LogicException {}
abstract class RuntimeException extends \RuntimeException {}

final class MissingValueDeclarationException extends RuntimeException {}