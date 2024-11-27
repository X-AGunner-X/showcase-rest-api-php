<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Components\Http\HttpExceptionInterface;
use App\Components\Http\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HttpErrorMiddleware implements MiddlewareInterface
{
	public function __construct(private ResponseFactory $responseFactory)
	{
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try {
			return $handler->handle($request);
		} catch (HttpExceptionInterface $exception) {
			$response = $this->responseFactory->createResponse();
			$response = $response->withStatus($exception->getHttpCode()->value);
			$response->getBody()->write(
				json_encode(
					[
					'message' => $exception->getMessage(),
					'error-type' => $exception->getErrorType(),
				],
					JSON_THROW_ON_ERROR
				)
			);
			return $response;
		}
	}
}
