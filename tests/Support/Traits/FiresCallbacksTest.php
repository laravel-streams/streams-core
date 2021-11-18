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

    public function test_can_observe_callbacks()
    {
        CallbacksTestClass::observeCallbacks(TestCallbackObserver::class);

        $instance = new CallbacksTestClass;

        $instance->fire('test_observing');

        $this->expectOutputString('Observed');
    }

    public function test_can_listen_for_callbacks()
    {
        CallbacksTestClass::addCallbackListener('test_listener', function () {
            echo 'Listen!';
        });

        $instance = new CallbacksTestClass;

        $instance->fire('test_listener');

        $this->expectOutputString('Listen!');
    }

    public function test_callbacks_are_specific_to_instance()
    {
        $instance = new CallbacksTestClass;

        $instance->addCallback('testing', function () {
            echo 'Testing';
        });

        $another = new CallbacksTestClass;

        $another->fire('testing');

        $this->expectOutputString('');
    }

    public function test_callbacks_are_detectable()
    {
        $instance = new CallbacksTestClass;

        $instance->addCallback('testing', function () {
            echo 'Testing';
        });

        $this->assertTrue($instance->hasCallback('testing'));
    }

    public function test_listeners_are_detectable()
    {
        CallbacksTestClass::addCallbackListener('detect_listener', function () {
            echo 'Listen!';
        });

        $instance = new CallbacksTestClass;

        $this->assertTrue($instance->hasCallbackListener('detect_listener'));
    }
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
    public function testObserving()
    {
        echo 'Observed';
    }
}
