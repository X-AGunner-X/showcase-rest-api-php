<?php

declare(strict_types=1);

namespace App\Application\Action\Exception;

use App\Components\Http\HttpExceptionInterface;
use App\Components\Http\HttpResponseCode;

class ForbiddenContentTypeException extends \RuntimeException implements HttpExceptionInterface
{
	private function __construct(string $allowedContentType)
	{
		parent::__construct(sprintf('Forbidden content type. Only %s allowed', $allowedContentType));
	}

	public static function createJsonAllowed(): self
	{
		return new self('application/json');
	}

	public function getHttpCode(): HttpResponseCode
	{
		return HttpResponseCode::BadRequest;
	}

	public function getErrorType(): string
	{
		return 'forbidden-content-type';
	}
}
