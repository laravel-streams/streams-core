<?php

class ApplicationTest extends StreamsTestCase
{
    /**
     *
     */
    public function testCanReturnAnArray()
    {
        $application = resolve(\Anomaly\Streams\Platform\Application\Application::class);

        $this->assertIsArray($application->toArray());
    }

    /**
     *
     */
    public function testCanReturnJson()
    {
        $application = resolve(\Anomaly\Streams\Platform\Application\Application::class);

        $this->assertJson($application->toJson());
    }
}