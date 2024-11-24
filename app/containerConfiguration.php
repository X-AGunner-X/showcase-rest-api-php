<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;

return static function (ContainerBuilder $containerBuilder): void {
	$containerBuilder->addDefinitions([
		Clock::class => fn () => new SystemClock(new DateTimeZone('Europe/Prague'))
	]);
};
