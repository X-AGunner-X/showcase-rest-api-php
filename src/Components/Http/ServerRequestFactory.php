<?php

declare(strict_types=1);

namespace App\Components\Http;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
	public function __construct(private ServerRequestFactoryInterface $psr7Factory)
	{
	}

	/**
	 * @param array<string, mixed> $serverParams
	 */
	public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
	{
		return $this->psr7Factory->createServerRequest($method, $uri, $serverParams);
	}
}
