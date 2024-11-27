<?php

declare(strict_types=1);

namespace App\Application\Action\Exception;

class ResponseDataEncodingError extends \LogicException
{
	private function __construct($exception)
	{
		parent::__construct(
			'Json error: ' . $exception->getMessage(),
			0,
			$exception
		);
	}

	public static function createFromException(\JsonException $exception): self
	{
		return new self($exception);
	}
}
