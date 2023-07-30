<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => ['arrays', 'arguments', 'parameters', 'match'],
        ],
        'array_indentation' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'break', 'continue', 'while', 'while', 'exit', 'if', 'switch', 'try', 'throw', 'yield'],
        ],
        'method_chaining_indentation' => true,
        'statement_indentation' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'length',
        ],
        'ternary_to_null_coalescing' => true,
        'single_line_throw' => false,
        'no_superfluous_phpdoc_tags' => true,
    ])
    ->setFinder($finder)
;
