<?php

declare(strict_types=1);

namespace App\Components\Redis;

use App\Components\Redis\Exception\RedisServerException;
use Predis\Client;
use Predis\Response\ServerException;

readonly class RedisClientWrapper
{
	public function __construct(private Client $redis)
	{
	}

	public function incrementBy(string $key, int $value): void
	{
		try {
			$this->redis->incrby($key, $value);
		} catch (ServerException $exception) {
			throw RedisServerException::create($exception);
		}
	}

	public function get(string $key): ?string
	{
		try {
			return $this->redis->get($key);
		} catch (ServerException $exception) {
			throw RedisServerException::create($exception);
		}
	}
}
