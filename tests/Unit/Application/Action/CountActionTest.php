<?php

declare(strict_types=1);

namespace Tests\App\Unit\Application\Action;

use App\Application\Action\CountAction;
use App\Domain\Redis\RedisFacade;
use App\Domain\Redis\RedisKey;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Tests\App\Unit\WithPsr7FactoriesTrait;

class CountActionTest extends TestCase
{
	use WithPsr7FactoriesTrait;

	private CountAction $countAction;
	private RedisFacade|MockObject $redisFacadeMock;

	protected function setUp(): void
	{
		$this->redisFacadeMock = $this->createMock(RedisFacade::class);

		$this->countAction = new CountAction($this->redisFacadeMock);
	}

	public function testInvokePreparesResponseWithCorrectData(): void
	{
		$expectedCount = 42;
		$this->redisFacadeMock
			->expects($this->once())
			->method('getCount')
			->willReturn($expectedCount);

		$requestMock = $this->createMock(ServerRequestInterface::class);
		$response = $this->createResponseFactory()->createResponse();

		$response = ($this->countAction)($requestMock, $response);

		$response->getBody()->rewind();
		$this->assertSame(
			$response->getBody()->getContents(),
			json_encode([RedisKey::TRACK_COUNT->value => $expectedCount], JSON_THROW_ON_ERROR)
		);
	}
}
