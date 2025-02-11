<?php

declare(strict_types=1);

namespace App\Domain\Track;

class TrackFactory
{
	public function create(): Track
	{
		return new Track();
	}
}
