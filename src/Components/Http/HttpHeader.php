<?php

namespace App\Components\Http;

enum HttpHeader: string
{
	case ACCEPT = 'Accept';
	case AUTHORIZATION = 'Authorization';
	case CACHE_CONTROL = 'Cache-Control';
	case CONTENT_LENGTH = 'Content-Length';
	case CONTENT_TYPE = 'Content-Type';
	case COOKIE = 'Cookie';
	case HOST = 'Host';
	case ORIGIN = 'Origin';
	case REFERER = 'Referer';
	case USER_AGENT = 'User-Agent';
	case X_REQUESTED_WITH = 'X-Requested-With';

	public function getDescription(): string
	{
		return match ($this) {
			self::ACCEPT => 'Specifies media types acceptable for the response.',
			self::AUTHORIZATION => 'Contains credentials to authenticate a client with a server.',
			self::CACHE_CONTROL => 'Specifies directives for caching mechanisms.',
			self::CONTENT_LENGTH => 'Indicates the size of the request body in bytes.',
			self::CONTENT_TYPE => 'Indicates the media type of the request body.',
			self::COOKIE => 'Contains stored HTTP cookies sent to the server.',
			self::HOST => 'Specifies the host and port number of the server receiving the request.',
			self::ORIGIN => 'Indicates the origin of the request.',
			self::REFERER => 'The address of the previous web page from which a link to the current page was followed.',
			self::USER_AGENT => 'Contains information about the user agent (e.g., browser) making the request.',
			self::X_REQUESTED_WITH => 'Used to identify Ajax requests (commonly sent by JavaScript frameworks).',
		};
	}
}
