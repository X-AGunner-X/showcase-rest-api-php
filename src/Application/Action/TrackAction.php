<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Components\Http\HttpContentType;
use App\Components\Http\RequestValidator;
use App\Components\Json\JsonRequestBodyMapper;
use App\Domain\File\FileFactory;
use App\Domain\File\FileName;
use App\Domain\File\FileWriter;
use App\Domain\Redis\RedisFacade;
use App\Domain\Track\TrackFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TrackAction
{
	public function __construct(
		private TrackFactory $trackFactory,
		private RequestValidator $requestValidator,
		private JsonRequestBodyMapper $requestBodyMapper,
		private FileWriter $fileWriter,
		private FileFactory $fileFactory,
		private RedisFacade $trackFacade,
	) {
	}

	public function __invoke(Request $request, Response $response): Response
	{
		$this->requestValidator->checkContentType($request, HttpContentType::APPLICATION_JSON);

		$track = $this->trackFactory->create();
		$contents = $request->getBody()->getContents();

		$this->requestBodyMapper->mapFromJson($contents, $track);

		$this->trackFacade->incrementTrackCount($track);

		$this->fileWriter->appendDataToFile($this->fileFactory->createStorageFile(FileName::TRACKING_FILE), $track);

		return $response;
	}
}
