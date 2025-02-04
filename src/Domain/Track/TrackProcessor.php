<?php

declare(strict_types=1);

namespace App\Domain\Track;

use App\Domain\Count\CountUpdaterInterface;

readonly class TrackProcessor
{
	public function __construct(
		private CountUpdaterInterface $countUpdater,
		private TrackDataStorageInterface $trackDataStorage,
	) {
	}

	public function processTrack(Track $track): void
	{
		if ($track->count !== null) {
			$this->countUpdater->incrementTrackCount($track);
		}

		$this->trackDataStorage->appendData($track);
	}
}
