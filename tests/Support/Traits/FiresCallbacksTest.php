<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Traits\FiresCallbacks;

class FiresCallbacksTest extends CoreTestCase
{

    public function test_it_adds_callbacks()
    {
        $instance = new CallbacksTestClass;

        $instance->addCallback('testing', function () {
            echo 'Testing';
        });

        $instance->fire('testing');

        $this->expectOutputString('Testing');
    }

    public function test_it_observes_callbacks()
    {
        CallbacksTestClass::observeCallbacks(TestCallbackObserver::class);

        $instance = new CallbacksTestClass;

        $instance->fire('test_observing');

        $this->expectOutputString('Observed');
    }

    public function test_it_listens_for_callbacks()
    {
        CallbacksTestClass::addCallbackListener('test_listener', function () {
            echo 'Listen!';
        });

        $instance = new CallbacksTestClass;

        $instance->fire('test_listener');

        $this->expectOutputString('Listen!');
    }

    public function test_it_isolates_callbacks_to_instances()
    {
        $instance = new CallbacksTestClass;

        $instance->addCallback('testing', function () {
            echo 'Testing';
        });

        $another = new CallbacksTestClass;

        $another->fire('testing');

        $this->expectOutputString('');
    }

    public function test_it_detects_callbacks()
    {
        $instance = new CallbacksTestClass;

        $instance->addCallback('testing', function () {
            echo 'Testing';
        });

        $this->assertTrue($instance->hasCallback('testing'));
    }

    public function test_it_detects_listeners()
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
