<?php

declare(strict_types=1);

namespace App\Components\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Response;

class ResponseFactory implements ResponseFactoryInterface {

	public function createResponse(int $code = 200, string $reasonPhrase = ''): Response {
		return new Response($code);
	}
}
