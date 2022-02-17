<?php

namespace Streams\Core\Tests\Image;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Image\Type\LocalImage;
use Streams\Core\Image\Type\RemoteImage;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Image\Type\StorageImage;

class ImageManagerTest extends CoreTestCase
{
    public function test_it_makes_public_images()
    {
        $this->assertInstanceOf(LocalImage::class, Images::make('public/vendor/testing/img/example.jpg'));
    }

    public function test_it_makes_remote_images()
    {
        $this->assertInstanceOf(RemoteImage::class, Images::make('https://source.unsplash.com/random'));
    }

    public function test_it_makes_storage_images()
    {
        $this->assertInstanceOf(StorageImage::class, Images::make('local://vendor/testing/img/example.jpg'));
    }

    public function test_it_throws_an_exception_for_unknown_sources()
    {
        $this->expectException(\exception::class);

        Images::make('---');
    }

    public function test_it_registers_images_by_name()
    {
        Images::register('test.jpg', 'public/vendor/testing/img/example.jpg');

        $this->assertInstanceOf(LocalImage::class, Images::make('test.jpg'));
    }

    public function test_it_adds_path_hints()
    {
        Images::addPath('public-testing', base_path('public/vendor/testing'));

        $this->assertInstanceOf(
            LocalImage::class,
            Images::make('public-testing::img/example.jpg')
        );
    }
}
