<?php

declare(strict_types=1);

namespace App\Components\Http;

interface HttpExceptionInterface extends \Throwable
{
	public function getHttpCode(): HttpResponseCode;

	public function getErrorType(): string;
}
