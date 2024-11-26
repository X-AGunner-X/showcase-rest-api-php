<?php

declare(strict_types=1);

namespace Tests\App\Unit;

use App\Components\Http\ResponseFactory;
use App\Components\Http\ServerRequestFactory;
use Psr\Http\Message\ServerRequestFactoryInterface;

trait WithPsr7FactoriesTrait {

	protected function createServerRequestFactory(): ServerRequestFactoryInterface {
		return new ServerRequestFactory(new \Slim\Psr7\Factory\ServerRequestFactory());
	}

	protected function createResponseFactory(): ResponseFactory
	{
		return new ResponseFactory();
	}
}
