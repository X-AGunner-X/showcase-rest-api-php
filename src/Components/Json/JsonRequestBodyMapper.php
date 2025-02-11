<?php

declare(strict_types=1);

namespace App\Components\Json;

use App\Components\Json\Exception\JsonBodyTypeError;
use App\Components\Json\Exception\JsonMustBeObjectException;
use App\Components\Json\Exception\JsonSyntaxErrorException;

class JsonRequestBodyMapper
{
	public function __construct(private \JsonMapper $jsonMapper)
	{
		$this->jsonMapper->bExceptionOnMissingData = true;
		$this->jsonMapper->bExceptionOnUndefinedProperty = true;
	}

	public function mapFromJson(string $json, object $targetObject): void
	{
		try {
			$decoded = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
		} catch (\JsonException $jsonException) {
			throw JsonSyntaxErrorException::fromJsonException($jsonException);
		}

		if (!$decoded instanceof \stdClass) {
			throw JsonMustBeObjectException::create();
		}

		try {
			$this->jsonMapper->map($decoded, $targetObject);
		} catch (\JsonMapper_Exception $jsonMapperException) {
			throw JsonBodyTypeError::createFromException($jsonMapperException);
		}
	}
}
