<?php

declare(strict_types=1);

namespace App\Components\Json\Exception;

use App\Components\Http\HttpExceptionInterface;
use App\Components\Http\HttpResponseCode;

class JsonSyntaxErrorException extends \RuntimeException implements HttpExceptionInterface
{
	private function __construct(\JsonException $exception)
	{
		parent::__construct(
			'Json error: ' . $exception->getMessage(),
			0,
			$exception
		);
	}

	public static function fromJsonException(\JsonException $jsonException): self
	{
		return new self($jsonException);
	}

	public function getHttpCode(): HttpResponseCode
	{
		return HttpResponseCode::BadRequest;
	}
	public function getErrorType(): string
	{
		return 'request.json-syntax-error';
	}
}
