<?php

declare(strict_types=1);

namespace App\Components\Config;

class Config
{
	public const string KEY_APP = 'app';

	public function __construct(private \Noodlehaus\Config $config)
	{
	}

	public function get(string $key, mixed $default = null): mixed
	{
		return $this->config->get($key, $default);
	}

	public function has(string $key): bool
	{
		return $this->config->has($key);
	}
}
