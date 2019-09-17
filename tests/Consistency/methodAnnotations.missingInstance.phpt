<?php declare(strict_types=1);
require __DIR__ . '/../bootstrap.php';

/**
 * Check if every method defined by '@method' annotation has corresponding instance.
 * Don’t depend on default `getConstantToScalar()` it may be overridden if Enum doesn’t use constants.
 */

/**
 * @method static MethodAnnotationsMissingInstance STATE_A()
 * @method static MethodAnnotationsMissingInstance STATE_B()
 */
abstract class MethodAnnotationsMissingInstance extends \Grifart\Enum\Enum
{

  protected static function provideInstances(): array
  {
    return [
        new class('a') extends MethodAnnotationsMissingInstance
        {
        },
    ];
  }

  protected static function getConstantToScalar(): array
  {
    return [
        'STATE_A' => 'a',
    ];
  }
}

\Tester\Assert::exception(
	function () {
    MethodAnnotationsMissingInstance::STATE_A();
	},
	\Grifart\Enum\UsageException::class,
	"Enum 'MethodAnnotationsMissingInstance' has annotated method STATE_B but it’s instance is not provided in 'provideInstances()'."
);
