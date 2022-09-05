<?php
$finder = PhpCsFixer\Finder::create()
    ->in('src');

return (new PhpCsFixer\Config)
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        '@DoctrineAnnotation' => true,
        'multiline_whitespace_before_semicolons' => array(
            'strategy' => 'no_multi_line',
        ),
        'array_syntax' => array(
            'syntax' => 'long',
        ),
        'return_assignment' => false,
        'ordered_class_elements' => false,
        'protected_to_private' => false,
        'declare_strict_types' => false,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'no_superfluous_phpdoc_tags' => false,
        'no_useless_else' => false,
        'types_spaces' => ['space' => 'single'],
        'phpdoc_summary' => false,
    ])
    ->setFinder($finder);
