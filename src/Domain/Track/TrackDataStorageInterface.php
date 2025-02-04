<?php

declare(strict_types=1);

namespace App\Domain\Track;

interface TrackDataStorageInterface
{
	public function appendData(Track $track): void;
}
