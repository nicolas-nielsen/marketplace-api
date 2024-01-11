<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('bin/console')
    ->exclude('config')
    ->exclude('public')
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP83Migration' => true,
        'mb_str_functions' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder($finder)
    ;
