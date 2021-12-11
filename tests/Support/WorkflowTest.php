<?php

namespace Streams\Core\Tests\Support;

use Tests\TestCase;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Traits\FiresCallbacks;

class WorkflowTest extends TestCase
{

    public function test_can_process_steps()
    {
        $workflow = new ExampleWorkflow;

        $this->expectOutputString('First!Second!');

        $workflow->process();
    }


    public function test_can_process_callable_arrays()
    {
        $workflow = new ExampleWorkflow;

        $workflow->addStep('another', [ExampleWorkflowStep::class, 'custom']);

        $this->expectOutputString('First!Second!Custom!');

        $workflow->process();
    }

    public function test_can_add_steps()
    {
        $workflow = new ExampleWorkflow;

        $workflow->addStep('another', ExampleWorkflowStep::class);

        $this->expectOutputString('First!Second!Extra!');

        $workflow->process();
    }

    public function test_can_add_step_to_front()
    {
        $workflow = new ExampleWorkflow;

        $workflow->doFirst('another', ExampleWorkflowStep::class);

        $this->expectOutputString('Extra!First!Second!');

        $workflow->process();
    }

    public function test_can_add_step_before_another()
    {
        $workflow = new ExampleWorkflow;

        $workflow->doBefore('second', 'another', ExampleWorkflowStep::class);

        $this->expectOutputString('First!Extra!Second!');

        $workflow->process();
    }

    public function test_can_add_step_after_another()
    {
        $workflow = new ExampleWorkflow;

        $workflow->doAfter('first', 'another', ExampleWorkflowStep::class);

        $this->expectOutputString('First!Extra!Second!');

        $workflow->process();
    }

    public function test_callbacks_are_fired_after_each_step()
    {
        $workflow = new ExampleWorkflow;

        $workflow->addCallback('before_first', function () {
            echo 'Before!';
        });

        $workflow->addCallback('after_second', function () {
            echo 'After!';
        });

        $this->expectOutputString('Before!First!Second!After!');

        $workflow->process();
    }

    public function test_callbacks_are_fired_on_pass_through_object()
    {
        $workflow = new ExampleWorkflow;

        $workflow->passThrough(new ExamplePassThroughObject);

        $this->expectOutputString('Start!First!Second!Last!');

        $workflow->process();
    }
}

class ExampleWorkflow extends Workflow
{
    public array $steps = [
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

class ExamplePassThroughObject
{
    use FiresCallbacks;

    public function onBeforeFirst()
    {
        echo 'Start!';
    }

    public function onAfterSecond()
    {
        echo 'Last!';
    }
}
