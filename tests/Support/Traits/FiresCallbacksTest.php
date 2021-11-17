<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Streams\Core\Support\Traits\FiresCallbacks;

class FiresCallbacksTest extends TestCase
{

    public function test_can_add_callbacks()
    {
        $instance = new CallbacksTestClass;

        $instance->addCallback('testing', function () {
            echo 'Testing';
        });

        $instance->fire('testing');

        $this->expectOutputString('Testing');
    }

    // public function test_can_observe_callbacks()
    // {
    //     CallbacksTestClass::observeCallbacks(TestCallbackObserver::class);

    //     $parent = new AnotherCallbacksTestClass;

    //     $parent->fire('testing');

    //     $this->expectOutputString('Observed');
    // }
}

class CallbacksTestClass
{
    use FiresCallbacks;
}

class AnotherCallbacksTestClass extends CallbacksTestClass
{
}

class TestCallbackObserver
{
    public function onTesting()
    {
        echo 'Observed';
    }
}
