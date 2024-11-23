<?php

declare(strict_types=1);

namespace App\Components\Application;

use App\Components\Config\Config;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

final class Bootstrap
{
	/** @var ContainerBuilder<\DI\Container> */
	private ContainerBuilder $containerBuilder;

	public function __construct()
	{
		$this->containerBuilder = new ContainerBuilder();
	}

	public function buildContainer(): ContainerInterface
	{
		$this->containerBuilder->addDefinitions([
			Config::class => function (ContainerInterface $container): Config {
				$configDir = APP_DIR . '/config/';

				return new Config(
					new \Noodlehaus\Config(
						[
							$configDir . '/config.json',
							$configDir . '/config-local.json',
						],
					)
				);
			}
		]);

		return $this->containerBuilder->build();
	}

	/**
	 * @return \Slim\App<\DI\Container>
	 */
	public function createSlimApi(ContainerInterface $container): App
	{
		/** @var App<\DI\Container> $app */
		$app = AppFactory::create();
		$app->addRoutingMiddleware();

		$routeLoader = $this->requireCallableFile(APP_DIR, 'routes.php');
		$routeLoader($app);

		return $app;
	}

	private function requireCallableFile(string $directoryPath, string $fileName): callable
	{
		$routeLoader = require sprintf('%s/%s', $directoryPath, $fileName);
		if (!is_callable($routeLoader)) {
			throw new \RuntimeException(sprintf('Expected %s to return a callable.', $fileName));
		}

		return $routeLoader;
	}
}
