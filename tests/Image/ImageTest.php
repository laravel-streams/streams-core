<?php

namespace Streams\Core\Tests\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Streams\Core\Tests\CoreTestCase;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\File;
use Streams\Core\Support\Facades\Images;

class ImageTest extends CoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(public_path('app/public'));
        
        App::register(HtmlServiceProvider::class);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('app/public'));   

        parent::tearDown();
    }

    public function test_it_returns_img_tags()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $url = url('app/public/vendor/testing/img/example.jpg');

        $this->assertEquals(
            '<img src="' . $url . '" alt="Example">',
            $image->version(false)->img()
        );

        $this->assertEquals(
            '<img src="' . $url . '" alt="Test">',
            $image->version(false)->img('Test')
        );

        $this->assertEquals(
            '<img src="' . $url . '?v=test" alt="Example">',
            $image->version('test')->img()
        );

        $this->assertEquals(
            '<img width="800px" src="' . $url . '" alt="Alternative">',
            $image->version(false)->img('Alternative', [
                'width' => '800px'
            ])
        );
    }

    public function test_it_returns_picture_elements()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $small = Images::make('public/vendor/testing/img/example.jpg')
            ->resize(400)
            ->quality(60)
            ->url();

        $medium = Images::make('public/vendor/testing/img/example.jpg')
            ->resize(800)
            ->quality(90)
            ->url();

        $this->assertEquals("<picture>
<source media=\"(min-width: 600px)\" srcset=\"" . $small . "\">
<source media=\"(min-width: 1600px)\" srcset=\"" . $medium . "\">
<img src=\"" . $image->url() . "\" alt=\"Example\">
</picture>", $image->picture([
            '(min-width: 600px)' => [
                'resize'  => 400,
                'quality' => 60
            ],
            '(min-width: 1600px)' => [
                'resize'  => 800,
                'quality' => 90
            ]
        ]));
    }

    public function test_it_supports_srcset()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $small = Images::make('public/vendor/testing/img/example.jpg')
            ->resize(400)
            ->quality(60)
            ->url();

        $medium = Images::make('public/vendor/testing/img/example.jpg')
            ->resize(800)
            ->quality(90)
            ->url();

        $this->assertEquals("<img srcset=\"" . $small . " 400w, " . $medium . " 800w\" sizes=\"(min-width: 600px) 400px, (min-width: 1600px) 800px\" src=\"" . url('app/public/vendor/testing/img/example.jpg') . "\" alt=\"Example\">", $image->srcset([
            '(min-width: 600px) 400px' => [
                'intrinsic' => 400,
                'resize' => 400,
                'quality' => 60
            ],
            '(min-width: 1600px) 800px' => [
                'intrinsic' => 800,
                'resize' => 800,
                'quality' => 90
            ]
        ])->img());
    }

    public function test_it_returns_links()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $small = Images::make('public/vendor/testing/img/example.jpg')
            ->resize(192, 192)
            ->url();

        $medium = Images::make('public/vendor/testing/img/example.jpg')
            ->resize(512, 512)
            ->url();

        $this->assertEquals("<link href=\"" . $small . "\" type=\"image/jpg\">
<link href=\"" . $medium . "\" type=\"image/jpg\">", $image->links([
            'android' => [
                'resize' => [192, 192],
                'sizes' => '192x192',
            ],
            'ios' => [
                'resize' => [512, 512],
                'sizes' => '512x512',
            ]
        ]));
    }

    public function test_it_returns_base64_data()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $this->assertStringStartsWith('data:image/jpg;base64,', $image->base64());

        $image = Images::make('public/vendor/testing/img/example.svg');

        $this->assertStringStartsWith('data:image/svg+xml;base64,', $image->base64());
    }

    public function test_it_returns_inline_images()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $output = $image->inline();

        $this->assertStringContainsString('alt="Example"', $output);
        $this->assertStringContainsString('<img src="data:image/jpg;base64,', $output);
    }

    public function test_it_returns_urls()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $url = url('app/public/vendor/testing/img/example.jpg?v=test');

        $this->assertSame($url, $image->version('test')->url());
    }

    public function test_it_returns_css_urls()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $url = url('app/public/vendor/testing/img/example.jpg?v=test');

        $this->assertSame('url(' . $url . ')', $image->version('test')->css());
    }

    public function test_it_returns_image_extensions()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $this->assertSame('jpg', $image->extension());
    }

    public function test_it_renames_output_files()
    {
        $image = Images::make('public/vendor/testing/img/example.jpg');

        $this->assertEquals(
            url('/app/public/vendor/testing/img/adjusted.jpg'),
            $image->version(false)->rename('adjusted.jpg')->fit(120, 120)->url()
        );
    }
}
