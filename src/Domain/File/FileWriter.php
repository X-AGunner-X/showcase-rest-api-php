<?php

declare(strict_types=1);

namespace App\Domain\File;

use App\Domain\File\Exception\JsonEncodeError;

class FileWriter
{
	public function appendDataToFile(File $file, \JsonSerializable $objectToAppend): void
	{
		try {
			$encodedData = json_encode($objectToAppend->jsonSerialize(), JSON_THROW_ON_ERROR);
		} catch (\JsonException $exception) {
			throw JsonEncodeError::createFrom($exception);
		}

		file_put_contents($file->getFullPath(), $encodedData . PHP_EOL, FILE_APPEND);
	}
}
