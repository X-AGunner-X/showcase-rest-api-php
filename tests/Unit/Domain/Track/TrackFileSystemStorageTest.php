<?php

declare(strict_types=1);

namespace Tests\App\Unit\Domain\Track;

use App\Components\File\File;
use App\Domain\Track\TrackFileSystemStorage;
use App\Components\File\FileFactory;
use App\Components\File\FileName;
use App\Components\File\FileWriter;
use App\Domain\Track\Track;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TrackFileSystemStorageTest extends TestCase
{
	private MockObject|FileWriter $fileWriterMock;
	private MockObject|FileFactory $fileFactoryMock;

	public function setUp(): void
	{
		$this->fileWriterMock = $this->createMock(FileWriter::class);
		$this->fileFactoryMock = $this->createMock(FileFactory::class);

		$this->storage = new TrackFileSystemStorage($this->fileWriterMock, $this->fileFactoryMock);
	}

	public function testAppendDataCallsFileWriterWithCorrectArguments(): void
	{
		$fileMock = $this->createMock(File::class);
		$this->fileFactoryMock->method('createStorageFile')
			->with(FileName::TRACKING_FILE)
			->willReturn($fileMock);

		$trackMock = $this->createMock(Track::class);
		$this->fileWriterMock->expects($this->once())
			->method('appendDataToFile')
			->with($fileMock, $trackMock);

		$this->storage->appendData($trackMock);
	}
}
