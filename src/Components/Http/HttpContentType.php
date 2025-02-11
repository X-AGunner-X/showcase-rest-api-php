<?php

namespace App\Components\Http;

enum HttpContentType: string
{
	case APPLICATION_JSON = 'application/json';
	case APPLICATION_FORM_URLENCODED = 'application/x-www-form-urlencoded';
	case MULTIPART_FORM_DATA = 'multipart/form-data';
	case APPLICATION_XML = 'application/xml';
	case TEXT_PLAIN = 'text/plain';
	case TEXT_HTML = 'text/html';
	case APPLICATION_JAVASCRIPT = 'application/javascript';
	case TEXT_CSS = 'text/css';
	case APPLICATION_OCTET_STREAM = 'application/octet-stream';
	case APPLICATION_PDF = 'application/pdf';
	case IMAGE_PNG = 'image/png';
	case IMAGE_JPEG = 'image/jpeg';
	case IMAGE_GIF = 'image/gif';

	public function getDescription(): string
	{
		return match ($this) {
			self::APPLICATION_JSON => 'JSON (application/json)',
			self::APPLICATION_FORM_URLENCODED => 'Form URL Encoded (application/x-www-form-urlencoded)',
			self::MULTIPART_FORM_DATA => 'Form Data (multipart/form-data)',
			self::APPLICATION_XML => 'XML (application/xml)',
			self::TEXT_PLAIN => 'Plain Text (text/plain)',
			self::TEXT_HTML => 'HTML (text/html)',
			self::APPLICATION_JAVASCRIPT => 'JavaScript (application/javascript)',
			self::TEXT_CSS => 'CSS (text/css)',
			self::APPLICATION_OCTET_STREAM => 'Binary Stream (application/octet-stream)',
			self::APPLICATION_PDF => 'PDF (application/pdf)',
			self::IMAGE_PNG => 'PNG Image (image/png)',
			self::IMAGE_JPEG => 'JPEG Image (image/jpeg)',
			self::IMAGE_GIF => 'GIF Image (image/gif)',
		};
	}
}
