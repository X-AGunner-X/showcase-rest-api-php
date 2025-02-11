<?php

declare(strict_types=1);

namespace App\Domain\Count;

readonly class CountFetcher
{
	public function __construct(private CountProviderInterface $countProvider)
	{
	}

	public function getCount(): int
	{
		return $this->countProvider->getCount();
	}
}
