<?php

declare(strict_types=1);

namespace App\Domain\Redis;

use App\Components\Redis\RedisClientWrapper;
use App\Domain\Track\Track;

class RedisFacade
{
	public function __construct(private RedisClientWrapper $redis)
	{
	}

	public function incrementTrackCount(Track $track): void
	{
		if ($track->count !== null) {
			$this->redis->incrementBy(RedisKey::TRACK_COUNT->value, $track->count);
		}
	}

	public function getCount(): int
	{
		return (int)$this->redis->get(RedisKey::TRACK_COUNT->value);
	}
}
