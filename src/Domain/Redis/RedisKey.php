<?php

declare(strict_types=1);

namespace App\Domain\Redis;

enum RedisKey: string
{
	case TRACK_COUNT = 'count';

	public function getType(): string
	{
		return match ($this) {
			self::TRACK_COUNT => 'int',
		};
	}
}
