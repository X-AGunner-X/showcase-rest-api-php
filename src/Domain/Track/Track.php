<?php

declare(strict_types=1);

namespace App\Domain\Track;

class Track implements \JsonSerializable
{
	/**
	 * @required
	 */
	public int $id;

	public ?int $count = null;

	/**
	 * @required
	 */
	public string $requiredString;

	public ?TrackStatistic $optionalStatistic = null;

	/**
	 * @return array<string, mixed>
	 */
	public function jsonSerialize(): array
	{
		return get_object_vars($this);
	}
}
