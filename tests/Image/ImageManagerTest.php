<?php

namespace Streams\Core\Tests\Image;

use Tests\TestCase;
use Streams\Core\Image\Image;
use Illuminate\Support\Facades\URL;
use Streams\Core\Image\ImageCollection;
use Streams\Core\Support\Facades\Images;

class ImageManagerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $filenames = [
            public_path('vendor/streams/core/tests/example.jpg'),
            public_path('vendor/streams/core/tests/example.png'),
        ];

        if (!is_dir(dirname($filenames[0]))) {
            mkdir(dirname($filenames[0]), 0777, true);
        }

        foreach ($filenames as $filename) {
            if (!file_exists($filename)) {
                copy(base_path('vendor/streams/core/tests/' . basename($filename)), $filename);
            }
        }
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filenames = [
            public_path('vendor/streams/core/tests/example.jpg'),
            public_path('vendor/streams/core/tests/example.png'),
        ];

        foreach ($filenames as $filename) {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    public function testMake()
    {
        $this->assertInstanceOf(Image::class, Images::make('vendor/streams/core/tests/example.jpg'));
        $this->assertInstanceOf(Image::class, Images::make('https://source.unsplash.com/random'));

        $this->expectException(\exception::class);

        Images::make('---');
    }

    public function testRegister()
    {
        Images::register('test.jpg', 'vendor/streams/core/tests/example.jpg');

        $this->assertInstanceOf(Image::class, Images::make('test.jpg'));
    }
}
