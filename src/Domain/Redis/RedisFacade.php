<?php

declare(strict_types=1);

namespace App\Domain\Redis;

use App\Components\Redis\RedisClientWrapper;
use App\Domain\Count\CountProviderInterface;
use App\Domain\Count\CountUpdaterInterface;
use App\Domain\Track\Track;

readonly class RedisFacade implements CountProviderInterface, CountUpdaterInterface
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
