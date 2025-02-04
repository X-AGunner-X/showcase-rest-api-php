<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return ECSConfig::configure()
	->withPaths([
		__DIR__ . '/src',
		__DIR__ . '/tests',
		__DIR__ . '/app',
	])
	->withPreparedSets(psr12: true)
	->withSpacing(indentation: Option::INDENTATION_TAB)
	->withRules([
		NoUnusedImportsFixer::class,
	]);
