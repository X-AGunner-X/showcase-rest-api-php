<?php

declare(strict_types=1);

namespace Tests\App\Unit\Components\Json;

use App\Components\Json\Exception\JsonBodyTypeError;
use App\Components\Json\Exception\JsonMustBeObjectException;
use App\Components\Json\Exception\JsonSyntaxErrorException;
use App\Components\Json\JsonRequestBodyMapper;
use JsonMapper;
use JsonMapper_Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JsonRequestBodyMapperTest extends TestCase
{
	private JsonRequestBodyMapper $mapper;

	private JsonMapper|MockObject $jsonMapperMock;

	protected function setUp(): void
	{
		$this->jsonMapperMock = $this->createMock(JsonMapper::class);

		$this->mapper = new JsonRequestBodyMapper($this->jsonMapperMock);
	}

	public function testMapFromJsonSuccessfullyMapsJsonToTargetObject(): void
	{
		$validJsonObject = '{"key": "value"}';
		$targetObject = new \stdClass();

		$this->jsonMapperMock
			->expects($this->once())
			->method('map')
			->with(
				$this->isInstanceOf(\stdClass::class),
				$this->identicalTo($targetObject)
			);

		$this->mapper->mapFromJson($validJsonObject, $targetObject);
	}

	public function testMapFromJsonThrowsSyntaxErrorExceptionOnInvalidJson(): void
	{
		$this->expectException(JsonSyntaxErrorException::class);

		$invalidJson = '{invalid_json}';

		$this->mapper->mapFromJson($invalidJson, new \stdClass());
	}

	public function testMapFromJsonThrowsMustBeObjectExceptionWhenJsonIsNotObject(): void
	{
		$this->expectException(JsonMustBeObjectException::class);

		$validNotObjectJsonArray = '["value1", "value2"]';

		$this->mapper->mapFromJson($validNotObjectJsonArray, new \stdClass());
	}

	public function testJsonMapperExceptionIsConvertedToBodyTypeError(): void
	{
		$this->expectException(JsonBodyTypeError::class);

		$validJsonObject = '{"key": "value"}';

		$this->jsonMapperMock
			->expects($this->once())
			->method('map')
			->willThrowException(new JsonMapper_Exception());

		$this->mapper->mapFromJson($validJsonObject, new \stdClass());
	}
}
