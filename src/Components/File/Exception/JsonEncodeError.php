<?php

declare(strict_types=1);

namespace App\Components\File\Exception;

class JsonEncodeError extends \LogicException
{
	private function __construct(private \JsonException $exception)
	{
		parent::__construct(
			'Json error: ' . $this->exception->getMessage(),
			0,
			$this->exception
		);
	}

	public static function createFrom(\JsonException $exception): self
	{
		return new self($exception);
	}
}
