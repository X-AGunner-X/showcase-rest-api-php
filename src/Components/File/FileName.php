<?php

namespace App\Components\File;

enum FileName: string
{
	case TRACKING_FILE = 'tracking-file';

	public function getDescription(): string
	{
		return match ($this) {
			self::TRACKING_FILE => 'file used to track json requests',
		};
	}
}
