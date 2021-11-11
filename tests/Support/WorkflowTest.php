<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Support\Workflow;
use Tests\TestCase;

class WorkflowTest extends TestCase
{

    public function test_can_process_steps()
    {
        $workflow = new ExampleWorkflow();

        $this->expectOutputString('First!Second!');

        $workflow->process();
    }

    public function test_can_process_additionally_passed_steps()
    {
        $workflow = new ExampleWorkflow([
            'another' => ExampleWorkflowStep::class
        ]);

        $this->expectOutputString('First!Second!Extra!');

        $workflow->process();
    }

    public function test_can_process_closure_steps()
    {
        $workflow = new ExampleWorkflow([
            'another' => function () {
                echo 'Closure!';
            }
        ]);

        $this->expectOutputString('First!Second!Closure!');

        $workflow->process();
    }
}

class ExampleWorkflow extends Workflow
{
    protected array $steps = [
        'first' => ExampleWorkflow::class . '@stepOne',
        'second' => ExampleWorkflow::class . '@stepTwo',
    ];

    public function stepOne()
    {
        echo 'First!';
    }

    public function stepTwo()
    {
        echo 'Second!';
    }
}

class ExampleWorkflowStep
{
    public function handle()
    {
        echo 'Extra!';
    }

    public function custom()
    {
        echo 'Custom!';
    }
}
