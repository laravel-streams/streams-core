<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Image\Facades\Images;

/**
 * Class ImageTest
 */
class ImageTest extends TestCase
{

    public function testMake()
    {
        $this->assert(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/cat.jpg')),
            Images::make('streams::testing/cat.jpg')->data()
        );
    }
}
