<?php

declare(strict_types=1);

namespace Tests\App\Unit\Domain;

use App\Components\File\Exception\JsonEncodeError;
use App\Components\File\File;
use App\Components\File\FileWriter;
use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
	private FileWriter $fileWriter;

	protected function setUp(): void
	{
		$this->fileWriter = new FileWriter();
	}

	public function testAppendDataToFileSuccessfullyWritesData(): void
	{
		$fileDummy = new File(__DIR__, 'file_write_test_file');

		$objectToAppend = $this->createMock(\JsonSerializable::class);
		$objectToAppend
			->expects($this->once())
			->method('jsonSerialize')
			->willReturn(['key' => 'value']);

		$secondObjectToAppend = $this->createMock(\JsonSerializable::class);
		$secondObjectToAppend
			->expects($this->once())
			->method('jsonSerialize')
			->willReturn(['second_key' => 'second_value']);

		if (file_exists($fileDummy->getFullPath())) {
			unlink($fileDummy->getFullPath());
		}

		$this->fileWriter->appendDataToFile($fileDummy, $objectToAppend);
		$this->fileWriter->appendDataToFile($fileDummy, $secondObjectToAppend);

		$this->assertFileExists($fileDummy->getFullPath());
		$this->assertFileEquals(__DIR__ . '/data/expectedTrackedFile', $fileDummy->getFullPath());

		unlink($fileDummy->getFullPath());
	}

	public function testAppendDataToFileThrowsJsonEncodeErrorOnEncodingFailure(): void
	{
		$fileDummy = new File(__DIR__, 'file_write_test_file');

		$objectToAppend = $this->createMock(\JsonSerializable::class);
		$objectToAppend
			->expects($this->once())
			->method('jsonSerialize')
			->willReturn("\xB1\x31"); // Invalid UTF-8 sequence to trigger JSON encoding error

		$this->expectException(JsonEncodeError::class);
		$this->fileWriter->appendDataToFile($fileDummy, $objectToAppend);
	}
}
