<?php

declare(strict_types=1);

namespace App\Components\Application;

use App\Application\Middleware\HttpErrorMiddleware;
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
			Config::class => function (): Config {
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

		$containerConfiguration = $this->requireCallableFile(APP_DIR, 'containerConfiguration.php');
		$containerConfiguration($this->containerBuilder);

		return $this->containerBuilder->build();
	}

	/**
	 * @return \Slim\App<\DI\Container>
	 */
	public function createSlimApi(ContainerInterface $container): App
	{
		$app = $this->createAppFromContainer($container);
		$app->addRoutingMiddleware();
		$this->addErrorMiddleware($container, $app);

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

	/**
	 * @return \Slim\App<\DI\Container>
	 */
	private function createAppFromContainer(ContainerInterface $container): App
	{
		AppFactory::setContainer($container);

		/** @var App<\DI\Container> $app */
		$app = AppFactory::create();
		return $app;
	}

	/**
	 * @param \Slim\App<\DI\Container> $app
	 */
	private function addErrorMiddleware(ContainerInterface $container, App $app): void
	{
		/** @var Config $config */
		$config = $container->get(Config::class);

		/** @var array{show_error_details: bool} $appConfig */
		$appConfig = $config->get(Config::KEY_APP);

		/** @var \App\Components\Application\LoggerFactory $loggerFactory */
		$loggerFactory = $container->get(LoggerFactory::class);

		$app->add(HttpErrorMiddleware::class);
		$app->addErrorMiddleware(
			$appConfig['show_error_details'],
			true,
			true,
			$loggerFactory->createLogger(LoggerFactory::LOGGER_APP)
		);
	}
}
