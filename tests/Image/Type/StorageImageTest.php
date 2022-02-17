<?php

namespace Streams\Core\Tests\Image\Type;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Streams\Core\Tests\CoreTestCase;
use Collective\Html\HtmlServiceProvider;
use Streams\Core\Support\Facades\Images;

class StorageImageTest extends CoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(public_path('app/img'));

        App::register(HtmlServiceProvider::class);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('app/img'));   

        parent::tearDown();
    }

    public function test_it_returns_img_tags()
    {
        $image = Images::make('local://img/example.jpg');

        $url = url('storage/img/example.jpg');

        $this->assertEquals(
            '<img src="' . $url . '" alt="Example">',
            $image->version(false)->img()
        );
    }

    public function test_it_detects_existence()
    {
        $image = Images::make('local://img/example.jpg');

        $this->assertTrue($image->exists());
    }

    public function test_it_returns_image_size()
    {
        $image = Images::make('local://img/example.jpg');

        $this->assertSame(263356, $image->size());
    }

    public function test_it_returns_last_modified_time()
    {
        $image = Images::make('local://img/example.jpg');

        $this->assertTrue($image->lastModified() > 0);
    }

    public function test_it_returns_image_data()
    {
        $image = Images::make('local://img/example.jpg');

        $this->assertNotEmpty($image->data());
    }
}
