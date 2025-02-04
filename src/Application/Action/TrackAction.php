<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Components\Http\HttpContentType;
use App\Components\Http\RequestValidator;
use App\Components\Json\JsonRequestBodyMapper;
use App\Domain\Track\TrackFactory;
use App\Domain\Track\TrackProcessor;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

readonly class TrackAction
{
	public function __construct(
		private TrackFactory $trackFactory,
		private RequestValidator $requestValidator,
		private JsonRequestBodyMapper $requestBodyMapper,
		private TrackProcessor $trackProcessor
	) {
	}

	public function __invoke(Request $request, Response $response): Response
	{
		$this->requestValidator->checkContentType($request, HttpContentType::APPLICATION_JSON);

		$contents = $request->getBody()->getContents();
		$track = $this->trackFactory->create();
		$this->requestBodyMapper->mapFromJson($contents, $track);

		$this->trackProcessor->processTrack($track);

		return $response;
	}
}
