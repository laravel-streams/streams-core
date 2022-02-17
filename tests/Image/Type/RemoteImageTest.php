<?php

namespace Streams\Core\Tests\Image\Type;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Images;

class RemoteImageTest extends CoreTestCase
{
    public function test_it_returns_img_tags()
    {
        $image = Images::make($url = 'https://via.placeholder.com/150');

        $this->assertEquals(
            '<img src="' . $url . '" alt="150">',
            $image->version(false)->img()
        );
    }

    public function test_it_detects_existence()
    {
        $image = Images::make('https://via.placeholder.com/150');

        $this->assertTrue($image->exists());

        $image = Images::make('https://streams.dev/example.jpg');

        $this->assertFalse($image->exists());
    }

    public function test_it_returns_image_size()
    {
        $image = Images::make('https://via.placeholder.com/150');

        $this->assertSame(373, $image->size());
    }

    public function test_it_returns_last_modified_time()
    {
        $image = Images::make('https://via.placeholder.com/150');

        $this->assertTrue($image->lastModified() > 0);
    }

    public function test_it_returns_image_data()
    {
        $image = Images::make('https://via.placeholder.com/150');

        $this->assertNotEmpty($image->data());
    }
}
