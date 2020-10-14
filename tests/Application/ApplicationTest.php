<?php

class ApplicationTest extends StreamsTestCase
{
    /**
     *
     */
    public function testCanReturnAnArray()
    {
        $application = resolve(\Streams\Core\Application\Application::class);

        $this->assertIsArray($application->toArray());
    }

    /**
     *
     */
    public function testCanReturnJson()
    {
        $application = resolve(\Streams\Core\Application\Application::class);

        $this->assertJson($application->toJson());
    }
}
