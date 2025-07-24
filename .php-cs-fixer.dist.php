<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/admin',
        __DIR__ . '/api',
        __DIR__ . '/config',
        __DIR__ . '/layout',
        __DIR__ . '/tests',
        __DIR__, // inclui os arquivos PHP na raiz
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->exclude(['vendor', 'infra', 'assets', 'node_modules']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'no_unused_imports' => true,
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
        'array_syntax' => ['syntax' => 'short'],
        'no_empty_statement' => true,
        'no_trailing_whitespace' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
