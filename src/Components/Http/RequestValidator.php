<?php

declare(strict_types=1);

namespace App\Components\Http;

use App\Application\Action\Exception\ForbiddenContentTypeException;
use Psr\Http\Message\RequestInterface;

class RequestValidator
{
	public function checkContentType(RequestInterface $request, HttpContentType $expectedContentType): void
	{
		$contentType = $request->getHeaderLine(HttpHeader::CONTENT_TYPE->value);

		if (!str_contains($contentType, $expectedContentType->value)) {
			throw ForbiddenContentTypeException::createJsonAllowed();
		}
	}
}
