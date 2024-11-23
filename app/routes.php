<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;

return static function (RouteCollectorProxyInterface $collector): void {
	$collector->get(
		'/',
		function (RequestInterface $request, ResponseInterface $response) {
			$response->getBody()->write("Hello world!");
			return $response;
		}
	);
};
