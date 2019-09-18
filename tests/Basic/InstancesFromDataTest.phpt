<?php declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use Grifart\Enum\InstancesFromData;
use Grifart\Enum\MissingValueDeclarationException;
use Tester\Assert;

/**
 * @method static DayOfWeek MONDAY()
 * @method static DayOfWeek TUESDAY()
 * @method static DayOfWeek WEDNESDAY()
 */
final class DayOfWeek extends \Grifart\Enum\Enum {

  use InstancesFromData;

  protected static function getInstancesData(): array
  {
    return [
        'MONDAY' => [
            'name' => 'Monday',
            'numeric' => 1,
        ],
        'TUESDAY' => [
            'name' => 'Tuesday',
            'numeric' => 2,
        ],
        'WEDNESDAY' => [
            'name' => 'Wednesday',
            'numeric' => 3,
        ],
    ];
  }

  public function getName(): string
  {
    return $this->getProperty('name');
  }

  public function getNumeric(): int
  {
    return $this->getProperty('numeric');
  }
}

Assert::same(DayOfWeek::MONDAY()->toScalar(), 'MONDAY', 'Check scalar value matches');

Assert::same(DayOfWeek::MONDAY()->getName(), 'Monday', 'Calling DayOfWeek->getMyText() methods returns correct value');
Assert::same(DayOfWeek::MONDAY()->getNumeric(), 1, 'Calling DayOfWeek->getNumeric() methods returns correct value');

Assert::same(DayOfWeek::fromScalar('TUESDAY'), DayOfWeek::TUESDAY(), 'Instance is correctly created from scalar.');

// Trying to create undefined enum item
Assert::exception(function () {
  DayOfWeek::fromScalar('THURSDAY');
}, MissingValueDeclarationException::class);

Assert::exception(function () {
  DayOfWeek::THURSDAY();
}, \Error::class, 'Call to undefined method DayOfWeek::THURSDAY(). Please check that you have provided constant, annotation and value.');

// Check creating is case-sensitive
Assert::exception(function () {
  DayOfWeek::monday();
}, \Error::class, 'Call to undefined method DayOfWeek::monday(). Please check that you have provided constant, annotation and value.');

Assert::exception(function () {
  DayOfWeek::fromScalar('monday');
}, MissingValueDeclarationException::class);
