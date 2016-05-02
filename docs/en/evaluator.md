# Evaluator

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

The evaluator is a simple service that evaluates a value from a mixed target.

    $value = $evaluator->evaluate($target, $arguments);

The evaluator recursively converts closures to their values and also parses dot notated tags within those strings with the arguments.

<hr>

<a name="basic-usage"></a>
## Basic Usage

You can evaluate your value by using the `\Anomaly\Streams\Platform\Support\Evaluator` class.

    $evaluator = app(Anomaly\Streams\Platform\Support\Evaluator::class);

    $evaluator->evaluate('{entry.name}', compact('entry')); // Ryan

    $evaluator->evaluate(
        function($entry) {
            return $entry->name;
        },
        compact('entry')
    ); // Ryan