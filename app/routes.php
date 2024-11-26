<?php

declare(strict_types=1);

use App\Application\Action\TrackAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

return static function (RouteCollectorProxyInterface $collector): void {
	$collector->post('/track', TrackAction::class);
};
