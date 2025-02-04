<?php

declare(strict_types=1);

namespace App\Domain\File;

class FileFactory
{
	public function createStorageFile(FileName $fileName): File
	{
		return new File(STORAGE_DIR, $fileName->value);
	}
}
