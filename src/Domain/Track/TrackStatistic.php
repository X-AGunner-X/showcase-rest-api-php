<?php

declare(strict_types=1);

namespace App\Domain\Track;

class TrackStatistic implements \JsonSerializable
{
	/**
	 * @required
	 */
	public string $name;

	/**
	 * @required
	 */
	public int $value;

	/**
	 * @return array<string, mixed>
	 */
	public function jsonSerialize(): array
	{
		return get_object_vars($this);
	}
}
