<?php

use Anomaly\Streams\Platform\Support\Evaluator;

class EvaluatorTest extends TestCase
{

    public function testCanEvaluateClosures()
    {
        $this->assertEquals(
            50,
            Evaluator::evaluate(
                function ($multiplier) {
                    return 5 * $multiplier;
                },
                ['multiplier' => 10]
            )
        );
    }

    public function testCanEvaluateArrays()
    {
        $this->assertEquals(
            ['Ryan', ['6\'3"'], 50],
            Evaluator::evaluate(
                [
                    'info.name',
                    [
                        'info.height'
                    ],
                    function ($multiplier) {
                        return 5 * $multiplier;
                    }
                ],
                [
                    'info'       => [
                        'name'   => 'Ryan',
                        'height' => '6\'3"'
                    ],
                    'multiplier' => 10
                ]
            )
        );
    }

    public function testCanEvaluateTraversableStrings()
    {
        $this->assertEquals(
            'Ryan',
            Evaluator::evaluate(
                'info.name',
                [
                    'info' => [
                        'name' => 'Ryan'
                    ]
                ]
            )
        );
    }
}
