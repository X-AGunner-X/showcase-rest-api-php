<?php

declare(strict_types=1);

namespace Tests\App\Unit\Domain\Redis;

use App\Components\Redis\RedisClientWrapper;
use App\Domain\Redis\RedisFacade;
use App\Domain\Redis\RedisKey;
use App\Domain\Track\Track;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RedisFacadeTest extends TestCase
{
	private RedisFacade $redisFacade;
	private RedisClientWrapper|MockObject $redisClientWrapperMock;

	protected function setUp(): void
	{
		$this->redisClientWrapperMock = $this->createMock(RedisClientWrapper::class);

		$this->redisFacade = new RedisFacade($this->redisClientWrapperMock);
	}

	public function testCountIncrementedOnTrackCountNotNull(): void
	{
		$trackDummy = new Track();
		$trackDummy->count = 42;

		$this->redisClientWrapperMock
			->expects($this->once())
			->method('incrementBy')
			->with(RedisKey::TRACK_COUNT->value, $trackDummy->count);

		$this->redisFacade->incrementTrackCount($trackDummy);
	}

	public function testIncrementTrackCountDoesNotCallRedisWhenCountIsNull(): void
	{
		$track = new Track();

		$this->assertNull($track->count);

		$this->redisClientWrapperMock
			->expects($this->never())
			->method('incrementBy');

		$this->redisFacade->incrementTrackCount($track);
	}

	public function testGetCount(): void
	{
		$this->redisClientWrapperMock
			->expects($this->once())
			->method('get')
			->with(RedisKey::TRACK_COUNT->value);

		$this->redisFacade->getCount();
	}

	public function testGetCountReturnZeroOnMissingCountInRedis(): void
	{
		$this->redisClientWrapperMock
			->expects($this->once())
			->method('get')
			->with(RedisKey::TRACK_COUNT->value)
			->willReturn(null);

		$this->redisFacade->getCount();
	}
}
