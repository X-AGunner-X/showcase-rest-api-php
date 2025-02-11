<?php

declare(strict_types=1);

namespace App\Components\Redis\Exception;

use Predis\Response\ServerException;

class RedisServerException extends \LogicException
{
	private function __construct(ServerException $exception)
	{
		parent::__construct(
			'Redis server exception: ' . $exception->getMessage(),
			0,
			$exception
		);
	}

	public static function create(ServerException $exception): self
	{
		return new self($exception);
	}
}
