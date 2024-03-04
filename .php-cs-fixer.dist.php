<?php

use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;

$header = <<<EOF
@project Chilean RUT
@link https://github.com/mnavarrocarter/chilean-rut
@package castor/log
@author Matias Navarro-Carter mnavarrocarter@gmail.com
@license MIT
@copyright 2024 Matias Navarro-Carter

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return (new PhpCsFixer\Config())
    ->setCacheFile('/tmp/php-cs-fixer')
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        'declare_strict_types' => true,
        'header_comment' => ['header' => $header, 'comment_type' => 'PHPDoc'],
        'yoda_style' => false,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'native_function_invocation' => [
            'include' => [NativeFunctionInvocationFixer::SET_ALL],
            'scope' => 'namespaced',
        ]
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(["src", "tests"])
    )
;
