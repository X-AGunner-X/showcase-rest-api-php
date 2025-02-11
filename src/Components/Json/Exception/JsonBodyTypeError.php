<?php

declare(strict_types=1);

namespace App\Components\Json\Exception;

use App\Components\Http\HttpExceptionInterface;
use App\Components\Http\HttpResponseCode;

class JsonBodyTypeError extends \DomainException implements HttpExceptionInterface
{
	private function __construct(\JsonMapper_Exception $exception)
	{
		parent::__construct(
			'Request body mapping strict type error',
			0,
			$exception
		);
	}

	public static function createFromException(\JsonMapper_Exception $exception): self
	{
		return new self($exception);
	}

	public function getHttpCode(): HttpResponseCode
	{
		return HttpResponseCode::BadRequest;
	}

	public function getErrorType(): string
	{
		return 'request.request-body-strict-type-error';
	}
}
