<?php

declare(strict_types=1);

use App\Application\Action\CountAction;
use App\Application\Action\TrackAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

return static function (RouteCollectorProxyInterface $collector): void {
	$collector->post('/track', TrackAction::class);
	$collector->get('/count', CountAction::class);
};
