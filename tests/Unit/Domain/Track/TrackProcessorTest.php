<?php

declare(strict_types=1);

namespace Tests\App\Unit\Domain\Track;

use App\Domain\Track\TrackProcessor;
use App\Domain\Track\TrackDataStorageInterface;
use App\Domain\Count\CountUpdaterInterface;
use App\Domain\Track\Track;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TrackProcessorTest extends TestCase
{
	private CountUpdaterInterface|MockObject $countUpdaterMock;
	private TrackDataStorageInterface|MockObject $trackDataStorageMock;
	private TrackProcessor $processor;

	public function setUp(): void
	{
		$this->countUpdaterMock = $this->createMock(CountUpdaterInterface::class);
		$this->trackDataStorageMock = $this->createMock(TrackDataStorageInterface::class);

		$this->processor = new TrackProcessor($this->countUpdaterMock, $this->trackDataStorageMock);
	}

	public function testProcessTrackIncrementsCountWhenNotNull(): void
	{
		$trackMock = $this->createMock(Track::class);
		$trackMock->count = 10;

		$this->countUpdaterMock->expects($this->once())
			->method('incrementTrackCount')
			->with($trackMock);

		$this->trackDataStorageMock->expects($this->once())
			->method('appendData')
			->with($trackMock);

		$this->processor->processTrack($trackMock);
	}

	public function testProcessTrackDoesNotIncrementCountWhenNull(): void
	{
		$trackMock = $this->createMock(Track::class);
		$trackMock->count = null;

		$this->countUpdaterMock->expects($this->never())
			->method('incrementTrackCount');

		$this->trackDataStorageMock->expects($this->once())
			->method('appendData')
			->with($trackMock);

		$this->processor->processTrack($trackMock);
	}
}
