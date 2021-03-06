<?php  declare(strict_types=1);
namespace MigratingOldCode;

require __DIR__ . '/../../bootstrap.php';

use Tester\Assert;

/**
 * @method static OrderState NEW()
 * @method static OrderState PROCESSING()
 */
final class OrderState extends \Grifart\Enum\Enum {
	use \Grifart\Enum\AutoInstances;
	public const NEW = 'new';
	public const PROCESSING = 'processing';
}

// code bellow is untouched:
$state = OrderState::NEW;

$result = '';
switch ($state) {
	// your business logic
	case OrderState::NEW:
		$result = 'new';
		break;
	case OrderState::PROCESSING:
		$result = 'processing';
		break;
}

Assert::same('new', $result);
