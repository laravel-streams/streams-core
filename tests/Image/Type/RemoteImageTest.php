<?php

namespace Streams\Core\Tests\Image\Type;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Images;

class RemoteImageTest extends CoreTestCase
{
    public $image = 'https://pyrocms-public.s3.us-east-2.amazonaws.com/laravel_streams_black_color_logomark.jpg';
    
    public function test_it_returns_img_tags()
    {
        $image = Images::make($url = $this->image);

        $this->assertEquals(
            '<img src="' . $url . '" alt="Laravel Streams Black Color Logomark">',
            $image->version(false)->img()
        );
    }

    public function test_it_detects_existence()
    {
        $image = Images::make($this->image);

        $this->assertTrue($image->exists());

        $image = Images::make('https://streams.dev/example.jpg');

        $this->assertFalse($image->exists());
    }

    public function test_it_returns_image_size()
    {
        $image = Images::make($this->image);

        $this->assertSame(101103, $image->size());
    }

    public function test_it_returns_last_modified_time()
    {
        $image = Images::make($this->image);

        $this->assertTrue($image->lastModified() > 0);
    }

    public function test_it_returns_image_data()
    {
        $image = Images::make($this->image);

        $this->assertNotEmpty($image->data());
    }
}
