<?php

declare(strict_types=1);

namespace Tests\App\Unit\Application\Action;

use App\Application\Action\TrackAction;
use App\Components\Http\HttpContentType;
use App\Components\Http\RequestValidator;
use App\Components\Json\JsonRequestBodyMapper;
use App\Domain\Count\CountUpdaterInterface;
use App\Domain\File\File;
use App\Domain\File\FileFactory;
use App\Domain\File\FileName;
use App\Domain\File\FileWriter;
use App\Domain\Track\Track;
use App\Domain\Track\TrackFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Response;
use Slim\Psr7\Stream;
use Tests\App\Unit\WithPsr7FactoriesTrait;

class TrackActionTest extends TestCase
{
	use WithPsr7FactoriesTrait;

	private TrackAction $trackAction;
	private TrackFactory|MockObject $trackFactoryMock;
	private RequestValidator|MockObject $requestValidatorMock;
	private JsonRequestBodyMapper|MockObject $jsonRequestBodyMapperMock;
	private FileWriter|MockObject $fileWriterMock;
	private FileFactory|MockObject $fileFactoryMock;
	private CountUpdaterInterface|MockObject $countUpdaterMock;

	public function setUp(): void
	{
		$this->trackFactoryMock = $this->createMock(TrackFactory::class);
		$this->requestValidatorMock = $this->createMock(RequestValidator::class);
		$this->jsonRequestBodyMapperMock = $this->createMock(JsonRequestBodyMapper::class);
		$this->fileWriterMock = $this->createMock(FileWriter::class);
		$this->fileFactoryMock = $this->createMock(FileFactory::class);
		$this->countUpdaterMock = $this->createMock(CountUpdaterInterface::class);

		$this->trackAction = new TrackAction(
			$this->trackFactoryMock,
			$this->requestValidatorMock,
			$this->jsonRequestBodyMapperMock,
			$this->fileWriterMock,
			$this->fileFactoryMock,
			$this->countUpdaterMock,
		);
	}

	public function testAction(): void
	{
		$contentsMock = 'contents-mock';
		$streamMock = $this->createMock(Stream::class);
		$streamMock
			->expects($this->once())
			->method('getContents')
			->willReturn($contentsMock);

		$request = $this->createServerRequestFactory()->createServerRequest('POST', 'any');
		$request = $request->withBody($streamMock);

		$this->requestValidatorMock
			->expects($this->once())
			->method('checkContentType')
			->with($request, HttpContentType::APPLICATION_JSON);

		$trackMock = $this->createMock(Track::class);
		$this->trackFactoryMock
			->expects($this->once())
			->method('create')
			->willReturn($trackMock);

		$this->jsonRequestBodyMapperMock
			->expects($this->once())
			->method('mapFromJson')
			->with($contentsMock, $trackMock);

		$this->countUpdaterMock
			->expects($this->once())
			->method('incrementTrackCount')
			->with($trackMock);

		$fileMock = $this->createMock(File::class);
		$this->fileFactoryMock
			->expects($this->once())
			->method('createStorageFile')
			->with(FileName::TRACKING_FILE)
			->willReturn($fileMock);

		$this->fileWriterMock
			->expects($this->once())
			->method('appendDataToFile')
			->with($fileMock, $trackMock);

		$responseMock = $this->createMock(Response::class);

		($this->trackAction)($request, $responseMock);
	}
}
