<?php

declare(strict_types=1);

namespace App\Domain\Track;

use App\Components\File\FileFactory;
use App\Components\File\FileName;
use App\Components\File\FileWriter;

readonly class TrackFileSystemStorage implements TrackDataStorageInterface
{
	public function __construct(
		private FileWriter $fileWriter,
		private FileFactory $fileFactory
	) {
	}

	public function appendData(Track $track): void
	{
		$this->fileWriter->appendDataToFile($this->fileFactory->createStorageFile(FileName::TRACKING_FILE), $track);
	}
}
