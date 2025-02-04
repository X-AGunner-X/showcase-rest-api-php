<?php

declare(strict_types=1);

namespace App\Domain\Count;

interface CountProviderInterface
{
	public function getCount(): int;
}
