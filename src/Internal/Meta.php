<?php declare(strict_types=1);

namespace Grifart\Enum\Internal;

use Grifart\Enum\Enum;
use Grifart\Enum\MissingValueValueException;

final class Meta
{
	/** @var string */
	private $class;
	/** @var array */
	private $constantToScalar;
	/** @var \Grifart\Enum\Enum[] */
	private $scalarToValue;

	private function __construct(string $class, array $constantToScalar, array $scalarToValue)
	{
		$this->class = $class;
		$this->constantToScalar = $constantToScalar;
		$this->scalarToValue = $scalarToValue;
	}

	public static function from(string $class, array $constantToScalar, array $scalarToValues): self
	{
		return new self($class, $constantToScalar, $scalarToValues);
	}

	public function getClass(): string
	{
		return $this->class;
	}

	/** @return string[] */
	public function getConstantNames(): array
	{
		return \array_keys($this->constantToScalar);
	}

	public function getScalarValues(): array
	{
		return \array_values($this->constantToScalar);
	}

	/** @return \Grifart\Enum\Enum[] */
	public function getValues(): array
	{
		return \array_values($this->scalarToValue);
	}

	public function getValueForConstantName($constantName): Enum
	{
		$scalar = $this->constantToScalar[$constantName];
		return $this->scalarToValue[$scalar];
	}

	public function hasValueForScalar($scalarValue): bool
	{
		return isset($this->scalarToValue[$scalarValue]);
	}

	public function getConstantNameForScalar($scalarValue): string
	{
		$result = \array_search($scalarValue, $this->constantToScalar, true);
		if ($result === false) {
			throw new \RuntimeException("Could not find constant name for $scalarValue.");
		}
		return $result;
	}

	public function getScalarForValue(Enum $enum)
	{
		$result = \array_search($enum, $this->scalarToValue, true);
		if ($result === false) {
			throw new \RuntimeException("Could not find scalar value given value.");
		}
		return $result;
	}

	/**
	 * @param int|string $scalar
	 * @throws MissingValueValueException if there is no value for given scalar
	 */
	public function getValueForScalar($scalar): Enum
	{
		if (!isset($this->scalarToValue[$scalar])) {
			throw new MissingValueValueException("There is no value for enum '{$this->class}' and scalar value '$scalar'.");
		}
		return $this->scalarToValue[$scalar];
	}
}
