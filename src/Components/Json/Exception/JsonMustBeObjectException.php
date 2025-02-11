<?php

declare(strict_types=1);

namespace App\Components\Json\Exception;

use App\Components\Http\HttpExceptionInterface;
use App\Components\Http\HttpResponseCode;

class JsonMustBeObjectException extends \DomainException implements HttpExceptionInterface
{
	public static function create(): self
	{
		return new self('Request Body must be valid JSON serialised object');
	}

	public function getHttpCode(): HttpResponseCode
	{
		return HttpResponseCode::BadRequest;
	}

	public function getErrorType(): string
	{
		return 'request.json-must-be-object';
	}
}
