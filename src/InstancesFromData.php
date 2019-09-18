<?php declare(strict_types=1);

namespace Grifart\Enum;


/**
 * Create enum instances from data array.
 * Advantages
 * - No need to define class constants
 * - Simpler creating of enum instances with a lot of properties
 *   - define your data in getInstancesData()
 *   - define getters for properties
 *
 * Disadvantages
 * - Less type safety. You are responsible for validity of instances_data yourself.
 *
 * @see test/InstancesFromDataTest.phpt
 */
trait InstancesFromData
{

  /** @var \Closure */
  private $dataCallback;

  abstract protected static function getInstancesData(): array;

  protected function __construct($scalarValue, $data)
  {
    $this->dataCallback = static function (string $name) use ($data) {
      if (!isset($data[$name])) {
        throw new UsageException("Instance is missing property '{$name}'");
      }
      return $data[$name];
    };
    parent::__construct($scalarValue);
  }

  protected static function provideInstances(): array
  {
    $instances = [];
    foreach (self::getInstancesData() as $scalar => $data) {
      $instances[] = new static($scalar, $data);
    }
    return $instances;
  }

  protected static function getConstantToScalar(): array
  {
    $map = [];
    foreach (self::getInstancesData() as $scalar => $data) {
      $map[$scalar] = $scalar;
    }
    return $map;
  }

  protected function getProperty(string $name)
  {
    return $this->dataCallback->__invoke($name);
  }
}