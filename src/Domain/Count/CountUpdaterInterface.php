<?php

declare(strict_types=1);

namespace App\Domain\Count;

use App\Domain\Track\Track;

interface CountUpdaterInterface
{
	public function incrementTrackCount(Track $track): void;
}
