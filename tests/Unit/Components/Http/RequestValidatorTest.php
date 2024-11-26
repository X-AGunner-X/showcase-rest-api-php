<?php

declare(strict_types=1);

namespace Tests\App\Unit\Components\Http;

use App\Application\Action\Exception\ForbiddenContentTypeException;
use App\Components\Http\HttpContentType;
use App\Components\Http\HttpHeader;
use App\Components\Http\RequestValidator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RequestValidatorTest extends TestCase
{
	private RequestValidator $validator;

	protected function setUp(): void
	{
		$this->validator = new RequestValidator();
	}

	public function testValidContentTypeDoesNotThrowException(): void
	{
		$requestMock = $this->createMock(RequestInterface::class);

		$requestMock
			->expects($this->once())
			->method('getHeaderLine')
			->with(HttpHeader::CONTENT_TYPE->value)
			->willReturn(HttpContentType::APPLICATION_JSON->value);

		$expectedContentType = HttpContentType::APPLICATION_JSON;
		$this->validator->checkContentType($requestMock, $expectedContentType);
	}

	public function testInvalidContentTypeThrowsException(): void
	{
		$this->expectException(ForbiddenContentTypeException::class);

		$requestMock = $this->createMock(RequestInterface::class);

		$requestMock
			->expects($this->once())
			->method('getHeaderLine')
			->with(HttpHeader::CONTENT_TYPE->value)
			->willReturn(HttpContentType::TEXT_HTML->value);

		$expectedContentType = HttpContentType::APPLICATION_JSON;
		$this->validator->checkContentType($requestMock, $expectedContentType);
	}

	public function testEmptyContentTypeThrowsException(): void
	{
		$this->expectException(ForbiddenContentTypeException::class);

		$requestMock = $this->createMock(RequestInterface::class);

		$requestMock
			->expects($this->once())
			->method('getHeaderLine')
			->with(HttpHeader::CONTENT_TYPE->value)
			->willReturn('');

		$expectedContentType = HttpContentType::APPLICATION_JSON;
		$this->validator->checkContentType($requestMock, $expectedContentType);
	}
}
