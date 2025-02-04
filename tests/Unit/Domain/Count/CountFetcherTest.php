<?php

declare(strict_types=1);

namespace Tests\App\Unit\Domain\Count;

use App\Domain\Count\CountProviderInterface;
use App\Domain\Count\CountFetcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CountFetcherTest extends TestCase
{
	private CountProviderInterface|MockObject $countProviderMock;
	private CountFetcher $countFetcher;

	public function setUp(): void
	{
		$this->countProviderMock = $this->createMock(CountProviderInterface::class);
		$this->countFetcher = new CountFetcher($this->countProviderMock);
	}

	public function testGetCountReturnsExpectedValue(): void
	{
		$expectedCount = 42;
		$this->countProviderMock->method('getCount')->willReturn($expectedCount);

		$this->assertSame($expectedCount, $this->countFetcher->getCount());
	}
}
