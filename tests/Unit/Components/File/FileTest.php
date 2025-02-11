<?php

declare(strict_types=1);

namespace Tests\App\Unit\Components\File;

use App\Components\File\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
	public function testGetFullPath(): void
	{
		$directoryPath = '/var/www/html';
		$fileName = 'test.txt';

		$file = new File($directoryPath, $fileName);

		$this->assertSame('/var/www/html/test.txt', $file->getFullPath());
	}
}
