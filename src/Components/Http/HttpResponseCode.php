<?php

namespace App\Components\Http;

enum HttpResponseCode: int
{
	case Continue = 100;
	case SwitchingProtocols = 101;
	case EarlyHints = 103;
	case Ok = 200;
	case Created = 201;
	case Accepted = 202;
	case NonAuthoritativeInformation = 203;
	case NoContent = 204;
	case ResetContent = 205;
	case PartialContent = 206;
	case MultipleChoices = 300;
	case MovedPermanently = 301;
	case Found = 302;
	case SeeOther = 303;
	case NotModified = 304;
	case TemporaryRedirect = 307;
	case PermanentRedirect = 308;
	case BadRequest = 400;
	case Unauthorized = 401;
	case PaymentRequired = 402;
	case Forbidden = 403;
	case NotFound = 404;
	case MethodNotAllowed = 405;
	case NotAcceptable = 406;
	case ProxyAuthenticationRequired = 407;
	case RequestTimeout = 408;
	case Conflict = 409;
	case Gone = 410;
	case LengthRequired = 411;
	case PreconditionFailed = 412;
	case PayloadTooLarge = 413;
	case UriTooLong = 414;
	case UnsupportedMediaType = 415;
	case RangeNotSatisfiable = 416;
	case ExpectationFailed = 417;
	case ImATeapot = 418;
	case UnprocessableEntity = 422;
	case TooEarly = 425;
	case UpgradeRequired = 426;
	case PreconditionRequired = 428;
	case TooManyRequests = 429;
	case RequestHeaderFieldsTooLarge = 431;
	case UnavailableForLegalReasons = 451;
	case InternalServerError = 500;
	case NotImplemented = 501;
	case BadGateway = 502;
	case ServiceUnavailable = 503;
	case GatewayTimeout = 504;
	case HttpVersionNotSupported = 505;
	case VariantAlsoNegotiates = 506;
	case InsufficientStorage = 507;
	case LoopDetected = 508;
	case NotExtended = 510;
	case NetworkAuthenticationRequired = 511;

	public function getDescription(): string
	{
		return match ($this) {
			self::Continue => 'Everything so far is OK and the client should continue with the request or ignore it if it is already finished.',
			self::SwitchingProtocols => 'The server is switching to the protocol that was specified in the Upgrade request header received from the client.',
			self::EarlyHints => 'Intended to be used with the Link header to allow the user agent to start preloading resources while the server is still preparing a response.',
			self::Ok => 'The request has succeeded.',
			self::Created => 'The request has succeeded and has led to the creation of a resource.',
			self::Accepted => 'The request has been accepted for processing, but the processing has not been completed.',
			self::NonAuthoritativeInformation => 'The request was successful but the enclosed payload has been modified by a transforming proxy from that of the origin server\'s 200 (OK) response.',
			self::NoContent => 'The request has succeeded, but that the client does not need to navigate away from its current page.',
			self::ResetContent => 'The client must reset the document view. For example, clear the content of a form, reset a canvas state, or refresh the UI.',
			self::PartialContent => 'The request has succeeded and the body contains the requested ranges of data, as described in the Range header of the request.',
			self::MultipleChoices => 'The request has more than one possible responses. The user-agent or the user should choose one of them.',
			self::MovedPermanently => 'The requested resource has been definitively moved to the URL given by the Location headers.',
			self::Found => 'The resource requested has been temporarily moved to the URL given by the Location headers.',
			self::SeeOther => 'The redirect does not link to the requested resource itself, but to another page.',
			self::NotModified => 'There is no need to retransmit the requested resources.',
			self::TemporaryRedirect => 'The resource has been temporarily moved to the URL given by the Location headers.',
			self::PermanentRedirect => 'The resource has been definitively moved to the URL given by the Location headers.',
			self::BadRequest => 'The server cannot or will not process the request due to something that is perceived to be a client error.',
			self::Unauthorized => 'The client request has not been completed because it lacks valid authentication credentials for the requested resource.',
			self::PaymentRequired => 'The resource is not available until the client makes a payment.',
			self::Forbidden => 'The server understands the request but refuses to authorize it.',
			self::NotFound => 'The server cannot find the resource.',
			self::MethodNotAllowed => 'The server knows the request method, but the target resource does not support this method.',
			self::NotAcceptable => 'The server cannot produce a response matching the list of acceptable values defined in the request\'s proactive content negotiation headers, and the server is unwilling to supply a default representation.',
			self::ProxyAuthenticationRequired => 'The request lacks valid authentication credentials for a proxy server that is between the browser and the server that can access the resource.',
			self::RequestTimeout => 'The server has shut down this unused connection.',
			self::Conflict => 'The request conflicts with the current state of the resource.',
			self::Gone => 'The resource is no longer available at the origin server and this condition is likely to be permanent.',
			self::LengthRequired => 'The server refuses to accept the request without a defined Content-Length header.',
			self::PreconditionFailed => 'Access to the resource has been denied because a precondition was not met.',
			self::PayloadTooLarge => 'The request entity is larger than limits defined by server.',
			self::UriTooLong => 'The URI requested by the client is longer than the server is willing to interpret.',
			self::UnsupportedMediaType => 'The server refuses to accept the request because the payload format is in an unsupported format.',
			self::RangeNotSatisfiable => 'The server cannot serve the requested ranges.',
			self::ExpectationFailed => 'The expectation given in the request\'s Expect header could not be met.',
			self::ImATeapot => 'The server refuses to brew coffee because it is, permanently, a teapot.',
			self::UnprocessableEntity => 'The server understands the content type of the request entity, and the syntax of the request entity is correct, but it was unable to process the contained instructions.',
			self::TooEarly => 'The server is unwilling to risk processing a request that might be replayed, which creates the potential for a replay attack.',
			self::UpgradeRequired => 'The server refuses to perform the request using the current protocol but might be willing to do so after the client upgrades to a different protocol.',
			self::PreconditionRequired => 'The server requires the request to be conditional.',
			self::TooManyRequests => 'The client has sent too many requests in a given amount of time ("rate limiting").',
			self::RequestHeaderFieldsTooLarge => 'The server refuses to process the request because the request\'s HTTP headers are too long. The request may be resubmitted after reducing the size of the request headers.',
			self::UnavailableForLegalReasons => 'The client requested a resource that is not available due to legal reasons, such as a web page for which a legal action has been issued.',
			self::InternalServerError => 'The server encountered an unexpected condition that prevented it from fulfilling the request.',
			self::NotImplemented => 'The server does not support the functionality required to fulfill the request.',
			self::BadGateway => 'The server, while acting as a gateway or proxy, received an invalid response from the upstream server.',
			self::ServiceUnavailable => 'The server is not ready to handle the request.',
			self::GatewayTimeout => 'The server, while acting as a gateway or proxy, did not get a response in time from the upstream server that it needed in order to complete the request.',
			self::HttpVersionNotSupported => 'The HTTP version used in the request is not supported by the server.',
			self::VariantAlsoNegotiates => 'The client must retrieve the best variant of a given resource, because the server supports multiple variants.',
			self::InsufficientStorage => 'The Web Distributed Authoring and Versioning (WebDAV) protocol does not have sufficient storage to service the request.',
			self::LoopDetected => 'The Web Distributed Authoring and Versioning (WebDAV) protocol detected a loop and cannot service the request.',
			self::NotExtended => 'The requested HTTP Extension Framework extension is not supported for the request.',
			self::NetworkAuthenticationRequired => 'The client needs to authenticate to gain network access.',
		};
	}

	public function getLabel(): string
	{
		return match ($this) {
			self::Continue => 'Continue',
			self::SwitchingProtocols => 'Switching Protocols',
			self::EarlyHints => 'Early Hints',
			self::Ok => 'Ok',
			self::Created => 'Created',
			self::Accepted => 'Accepted',
			self::NonAuthoritativeInformation => 'Non-Authoritative Information',
			self::NoContent => 'No Content',
			self::ResetContent => 'Reset Content',
			self::PartialContent => 'Partial Content',
			self::MultipleChoices => 'Multiple Choices',
			self::MovedPermanently => 'Moved Permanently',
			self::Found => 'Found',
			self::SeeOther => 'See Other',
			self::NotModified => 'Not Modified',
			self::TemporaryRedirect => 'Temporary Redirect',
			self::PermanentRedirect => 'Permanent Redirect',
			self::BadRequest => 'Bad Request',
			self::Unauthorized => 'Unauthorized',
			self::PaymentRequired => 'Payment Required',
			self::Forbidden => 'Forbidden',
			self::NotFound => 'Not Found',
			self::MethodNotAllowed => 'Method Not Allowed',
			self::NotAcceptable => 'Not Acceptable',
			self::ProxyAuthenticationRequired => 'Proxy Authentication Required',
			self::RequestTimeout => 'Request Timeout',
			self::Conflict => 'Conflict',
			self::Gone => 'Gone',
			self::LengthRequired => 'Length Required',
			self::PreconditionFailed => 'Precondition Failed',
			self::PayloadTooLarge => 'Payload Too Large',
			self::UriTooLong => 'Uri Too Long',
			self::UnsupportedMediaType => 'Unsupported Media Type',
			self::RangeNotSatisfiable => 'Range Not Satisfiable',
			self::ExpectationFailed => 'Expectation Failed',
			self::ImATeapot => 'I\'m a teapot',
			self::UnprocessableEntity => 'Unprocessable Entity',
			self::TooEarly => 'Too Early',
			self::UpgradeRequired => 'Upgrade Required',
			self::PreconditionRequired => 'Precondition Required',
			self::TooManyRequests => 'Too Many Requests',
			self::RequestHeaderFieldsTooLarge => 'Request Header Fields Too Large',
			self::UnavailableForLegalReasons => 'Unavailable For Legal Reasons',
			self::InternalServerError => 'Internal Server Error',
			self::NotImplemented => 'Not Implemented',
			self::BadGateway => 'Bad Gateway',
			self::ServiceUnavailable => 'Service Unavailable',
			self::GatewayTimeout => 'Gateway Timeout',
			self::HttpVersionNotSupported => 'Http Version Not Supported',
			self::VariantAlsoNegotiates => 'Variant Also Negotiates',
			self::InsufficientStorage => 'Insufficient Storage',
			self::LoopDetected => 'Loop Detected',
			self::NotExtended => 'Not Extended',
			self::NetworkAuthenticationRequired => 'Network Authentication Required',
		};
	}
}
