<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = new Finder()
    ->in(__DIR__)
    ->exclude('var');

return new Config()
    ->setRules([
        '@PSR12' => true,
        '@PER-CS2.0' => true,
        'declare_strict_types' => true,
        'strict_param' => true,
        'single_quote' => true,
        'no_unused_imports' => true,
    ])
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setFinder($finder);
