<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->parallel();

    $ecsConfig->cacheDirectory('.phpecs');

    $ecsConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/migrations',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $ecsConfig->sets([
        SetList::CLEAN_CODE,
        SetList::COMMON,
        SetList::DOCTRINE_ANNOTATIONS,
        SetList::PSR_12,
        SetList::SYMPLIFY,
    ]);

    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    $ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'method' => ClassAttributesSeparationFixer::SPACING_ONE,
        ],
    ]);

    $ecsConfig->skip([
        // avoid converting `$i += 1` to `++$i`
        StandardizeIncrementFixer::class,
        // avoid converting `if (!$foo)` to `if (! $foo)`
        NotOperatorWithSuccessorSpaceFixer::class,
        // avoid changing `[1,2,3]` to
        // [
        //     1,
        //     2,
        //     3,
        // ]
        ArrayListItemNewlineFixer::class,
        StandaloneLineInMultilineArrayFixer::class,
        ArrayOpenerAndCloserNewlineFixer::class,
        // These will break the codebase, but we should enable them eventually
        StrictComparisonFixer::class,
        StrictParamFixer::class,
        // We do this a lot and it cannot be autofixed
        AssignmentInConditionSniff::class,
        // Enable in a separate PR due to diff noise
        OrderedClassElementsFixer::class,
    ]);
};
