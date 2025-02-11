<?php

declare(strict_types=1);

namespace Tests\App\Unit\Components\File;

use App\Components\File\File;
use App\Components\File\FileWriter;
use App\Components\File\Exception\JsonEncodeError;
use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
	private string $tempFilePath;

	protected function setUp(): void
	{
		$this->tempFilePath = tempnam(sys_get_temp_dir(), 'test');
	}

	protected function tearDown(): void
	{
		@unlink($this->tempFilePath);
	}

	public function testAppendDataToFile(): void
	{
		$file = new File(dirname($this->tempFilePath), basename($this->tempFilePath));
		$fileWriter = new FileWriter();

		$objectToAppend = new class implements \JsonSerializable {
			public function jsonSerialize(): array
			{
				return ['key' => 'value'];
			}
		};

		$fileWriter->appendDataToFile($file, $objectToAppend);

		$this->assertStringContainsString(
			json_encode($objectToAppend->jsonSerialize(), JSON_THROW_ON_ERROR) . PHP_EOL,
			file_get_contents($this->tempFilePath)
		);
	}

	public function testAppendDataToFileThrowsJsonEncodeError(): void
	{
		$this->expectException(JsonEncodeError::class);

		$file = new File(dirname($this->tempFilePath), basename($this->tempFilePath));
		$fileWriter = new FileWriter();

		$invalidObject = new class implements \JsonSerializable {
			public function jsonSerialize(): mixed
			{
				return INF;
			}
		};

		$fileWriter->appendDataToFile($file, $invalidObject);
	}
}
