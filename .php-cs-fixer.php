<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/scripts',
        __DIR__.'/tests',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
    ]);
