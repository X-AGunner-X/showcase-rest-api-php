<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Application\Action\Exception\ResponseDataEncodingError;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseAction
{
	/**
	 * @param array<string, mixed> $responseData
	 */
	protected function prepareData(Response $response, array $responseData): void
	{
		try {
			$encodedData = json_encode($responseData, JSON_THROW_ON_ERROR);
		} catch (\JsonException $exception) {
			throw ResponseDataEncodingError::createFromException($exception);
		}

		$response->getBody()->write($encodedData);
		$response->withHeader('Content-Type', 'application/json');
	}
}
