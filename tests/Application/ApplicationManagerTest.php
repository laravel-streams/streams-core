<?php

/**
 * @todo complete tests
 *
 * Class ApplicationManagerTest
 */
class ApplicationManagerTest extends StreamsTestCase
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testCanMakeAnApplicationInstance()
    {
        $manager = app(\Anomaly\Streams\Platform\Application\ApplicationManager::class);

        $application = $manager->make('default');

        $this->assertInstanceOf(\Anomaly\Streams\Platform\Application\Application::class, $application);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testWillReturnEnvironmentHandle()
    {
        $this->markTestIncomplete();

        $manager = app(\Anomaly\Streams\Platform\Application\ApplicationManager::class);

        $application = $manager->make();

        $this->assertEquals('testing', $application->handle);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testCanMakeAnApplicationWithAParticularHandle()
    {
        $this->markTestIncomplete('@todo how to test multiple applications here.');

        /** @var \Anomaly\Streams\Platform\Application\ApplicationManager $manager */
        $manager = app(\Anomaly\Streams\Platform\Application\ApplicationManager::class);

        /** @var \Anomaly\Streams\Platform\Application\Application $application */
        $application = $manager->make('random');

        $this->assertEquals('random', $manager->handle());
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testCanSwitchAnApplicationToOrigin()
    {
        $this->markTestIncomplete();

        $manager = app(\Anomaly\Streams\Platform\Application\ApplicationManager::class);

        /** @var \Anomaly\Streams\Platform\Application\Application $application */
        $application = $manager->make('default');

        $manager->switch('testing');

        $this->assertEquals('testing', $manager->handle());
    }
}