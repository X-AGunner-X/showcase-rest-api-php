<?php

declare(strict_types=1);

namespace Tests\App\Unit\Application\Middleware;

use App\Application\Middleware\HttpErrorMiddleware;
use App\Components\Http\DummyHttpException;
use App\Components\Http\ResponseFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Request;
use Tests\App\Unit\WithPsr7FactoriesTrait;

class HttpErrorMiddlewareTest extends TestCase
{
	use WithPsr7FactoriesTrait;

	private HttpErrorMiddleware $middleware;
	private ResponseFactory|MockObject $responseFactoryMock;

	protected function setUp(): void
	{
		$this->responseFactoryMock = $this->createMock(ResponseFactory::class);
		$this->middleware = new HttpErrorMiddleware($this->responseFactoryMock);
	}

	public function testProcessHandlesHttpException(): void
	{
		$exception = DummyHttpException::create();

		$handlerMock = $this->createMock(RequestHandlerInterface::class);
		$handlerMock
			->expects($this->once())
			->method('handle')
			->willThrowException($exception);

		$requestMock = $this->createMock(ServerRequestInterface::class);

		$response = $this->createResponseFactory()->createResponse();

		$this->responseFactoryMock
			->expects($this->once())
			->method('createResponse')
			->willReturn($response);

		$response = $this->middleware->process($requestMock, $handlerMock);
		$response->getBody()->rewind();

		$this->assertSame($exception->getHttpCode()->value, $response->getStatusCode());
		$this->assertSame(
			json_encode([
				'message' => $exception->getMessage(),
				'error-type' => $exception->getErrorType(),
			], JSON_THROW_ON_ERROR),
			$response->getBody()->getContents()
		);
	}

	public function testDoesNotCatchNonHttpException(): void
	{
		$handlerMock = $this->createMock(RequestHandlerInterface::class);
		$exception = new \Exception('random exception');
		$handlerMock
			->expects($this->once())
			->method('handle')
			->willThrowException($exception);

		$this->expectException(\Exception::class);

		$this->middleware->process(
			$this->createMock(Request::class),
			$handlerMock
		);
	}

	public function testProcessPassesThroughWithoutException(): void
	{
		$requestMock = $this->createMock(ServerRequestInterface::class);
		$responseMock = $this->createMock(ResponseInterface::class);

		$handlerMock = $this->createMock(RequestHandlerInterface::class);
		$handlerMock
			->expects($this->once())
			->method('handle')
			->with($requestMock)
			->willReturn($responseMock);

		$response = $this->middleware->process($requestMock, $handlerMock);

		$this->assertSame($responseMock, $response);
	}
}
