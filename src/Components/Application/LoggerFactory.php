<?php

declare(strict_types=1);

namespace App\Components\Application;

use Lcobucci\Clock\Clock;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
	public const string LOGGER_APP = 'app';

	public function __construct(private Clock $clock)
	{
	}

	public function createLogger(string $name, Level $level = Level::Info): LoggerInterface
	{
		$logger = new Logger(self::LOGGER_APP);
		$date = $this->clock->now()->format('Y-m-d');

		$logger->pushHandler(
			new StreamHandler(
				sprintf('%s/%s-%s.log', LOG_DIR, $name, $date),
				$level
			)
		);

		return $logger;
	}
}
