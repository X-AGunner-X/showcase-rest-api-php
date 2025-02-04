<?php

declare(strict_types=1);

namespace Tests\App\Unit\Application\Action;

use App\Application\Action\CountAction;
use App\Domain\Count\CountProviderInterface;
use App\Domain\Count\CountFetcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Tests\App\Unit\WithPsr7FactoriesTrait;

class CountActionTest extends TestCase
{
	use WithPsr7FactoriesTrait;

	private CountAction $countAction;
	private CountProviderInterface|MockObject $countServiceMock;

	protected function setUp(): void
	{
		$this->countServiceMock = $this->createMock(CountFetcher::class);

		$this->countAction = new CountAction($this->countServiceMock);
	}

	public function testInvokePreparesResponseWithCorrectData(): void
	{
		$expectedCount = 42;
		$this->countServiceMock
			->expects($this->once())
			->method('getCount')
			->willReturn($expectedCount);

		$requestMock = $this->createMock(ServerRequestInterface::class);
		$response = $this->createResponseFactory()->createResponse();

		$response = ($this->countAction)($requestMock, $response);

		$response->getBody()->rewind();
		$this->assertSame(
			$response->getBody()->getContents(),
			json_encode(['count' => $expectedCount], JSON_THROW_ON_ERROR)
		);
	}
}
