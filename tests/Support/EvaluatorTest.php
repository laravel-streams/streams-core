<?php


use Anomaly\Streams\Platform\Support\Evaluator;

/**
 *
 * Class EvaluatorTest
 */
class EvaluatorTest extends StreamsTestCase
{

    public function testCanEvaluateClosures()
    {
        $evaluator = app(Evaluator::class);

        $this->assertEquals(
            50,
            $evaluator->evaluate(
                function ($multiplier) {
                    return 5 * $multiplier;
                },
                ['multiplier' => 10]
            )
        );
    }

    public function testCanEvaluateArrays()
    {
        $evaluator = app(Evaluator::class);


        $this->assertEquals(
            ['Ryan', ['6\'3"'], 50],
            $evaluator->evaluate(
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
        $evaluator = app(Evaluator::class);


        $this->assertEquals(
            'Ryan',
            $evaluator->evaluate(
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
