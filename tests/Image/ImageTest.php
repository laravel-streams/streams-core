<?php

namespace Streams\Core\Tests\Image;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Support\Facades\Images;

class ImageTest extends TestCase
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
            public_path('vendor/streams/core/tests/adjusted.jpg'),
            public_path('vendor/streams/core/tests/example.png'),
            public_path('app/vendor/streams/core/tests/example.jpg'),
            public_path('app/vendor/streams/core/tests/adjusted.jpg'),
            public_path('app/vendor/streams/core/tests/example.png'),
        ];

        foreach ($filenames as $filename) {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    public function testImg()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertEquals('<img src="' . url('/app/vendor/streams/core/tests/example.jpg') . '" alt="Example">', $image->version(false)->img());
        $this->assertEquals('<img src="' . url('/app/vendor/streams/core/tests/example.jpg') . '" alt="Test">', $image->version(false)->img('Test'));
        $this->assertEquals('<img src="' . url('/app/vendor/streams/core/tests/example.jpg?v=test') . '" alt="Example">', $image->version('test')->img());
    }

    public function testVersion()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertEquals(url('/app/vendor/streams/core/tests/example.jpg?v=latest'), $image->version('latest')->url());
        $this->assertEquals(url('/app/vendor/streams/core/tests/example.jpg?v=' . filemtime(base_path('vendor/streams/core/tests/example.jpg'))), $image->version(true)->url());
    }

    // public function testPicture()
    // {
    //     $image = Images::make('vendor/streams/core/tests/example.jpg');

    //     $image->sources([
    //         '(min-width: 600px)' => [
    //             'resize'  => 400,
    //             'quality' => 60
    //         ],
    //         '(min-width: 1600px)' => [
    //             'resize'  => 800,
    //             'quality' => 90
    //         ],
    //         'fallback' => [
    //             'resize'  => 1800
    //         ]
    //     ]);

    //     $this->assertEquals('<img src="https://streams.local:8890/app/vendor/streams/core/tests/example.jpg" alt="Example">', $image->picture());
    // }

    public function testBase64()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertStringStartsWith('data:image/jpg;base64,', $image->base64());
    }

    public function testInline()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertTrue(Str::is('<img src="data:image/jpg;base64,*" alt="Example">', $image->inline()));
    }

    public function testCss()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertEquals('url(' . url('/app/vendor/streams/core/tests/example.jpg') . ')', $image->version(false)->css());
    }

    public function testExtension()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertEquals('jpg', $image->extension());
        $this->assertEquals('jpg', $image->extension());
    }

    public function testAlterations()
    {
        $image = Images::make('vendor/streams/core/tests/example.jpg');

        $this->assertEquals(url('/app/vendor/streams/core/tests/adjusted.jpg'), $image->version(false)->rename('adjusted.jpg')->fit(120, 120)->url());
    }
}
