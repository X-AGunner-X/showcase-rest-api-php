<?php

declare(strict_types=1);

namespace App\Components\Http;

/**
 * @internal for testing purposes
 */
class DummyHttpException extends \RuntimeException implements HttpExceptionInterface
{
	private function __construct()
	{
		parent::__construct('dummy exception');
	}

	public static function create(): self
	{
		return new self();
	}

	public function getHttpCode(): HttpResponseCode
	{
		return HttpResponseCode::BadRequest;
	}

	public function getErrorType(): string
	{
		return 'dummy-exception-for-testing';
	}
}
