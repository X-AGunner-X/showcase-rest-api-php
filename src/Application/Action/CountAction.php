<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\Redis\RedisFacade;
use App\Domain\Redis\RedisKey;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CountAction extends BaseAction
{
	public function __construct(private RedisFacade $redisFacade)
	{
	}

	public function __invoke(Request $request, Response $response): Response
	{
		$count = $this->redisFacade->getCount();

		$this->prepareData(
			$response,
			[
				RedisKey::TRACK_COUNT->value => $count
			]
		);

		return $response;
	}
}
