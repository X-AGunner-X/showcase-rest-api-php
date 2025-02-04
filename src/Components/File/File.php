<?php

declare(strict_types=1);

namespace App\Components\File;

readonly class File
{
	public function __construct(public string $directoryPath, public string $fileName)
	{
	}

	public function getFullPath(): string
	{
		return sprintf('%s/%s', $this->directoryPath, $this->fileName);
	}
}
