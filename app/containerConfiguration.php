<?php

declare(strict_types=1);

use App\Components\Config\Config;
use DI\ContainerBuilder;
use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Predis\Client as PredisClient;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $containerBuilder): void {
	$containerBuilder->addDefinitions([
		Clock::class => fn () => new SystemClock(new DateTimeZone('Europe/Prague')),
		PredisClient::class => function (ContainerInterface $container): PredisClient {
			/** @var Config $config */
			$config = $container->get(Config::class);

			/** @var array{scheme:string, host: string, port: int} $redisConfig */
			$redisConfig = $config->get(Config::KEY_REDIS);

			return new PredisClient(
				[
					'scheme' => $redisConfig['scheme'],
					'host' => $redisConfig['host'],
					'port' => $redisConfig['port'],
				]
			);
		},
	]);
};
