<?php

namespace Streams\Core\Tests\Asset;

use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use Streams\Core\Asset\AssetCollection;
use Streams\Core\Support\Facades\Assets;

class AssetManagerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $filenames = [
            public_path('vendor/streams/core/tests/testing.js'),
            public_path('vendor/streams/core/tests/testing.css'),
        ];

        if (!is_dir(dirname($filenames[0]))) {
            mkdir(dirname($filenames[0]), 0777, true);
        }

        foreach ($filenames as $filename) {
            if (!file_exists($filename)) {
                file_put_contents($filename, 'Test ' . basename($filename), );
            }
        }
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filenames = [
            public_path('vendor/streams/core/tests/testing.js'),
            public_path('vendor/streams/core/tests/testing.css'),
        ];

        foreach ($filenames as $filename) {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    public function testAdd()
    {
        Assets::add('styles', 'style.css');

        $this->assertEquals(1, Assets::collection('styles')->count());
    }

    public function testCollection()
    {
        Assets::add('scripts', 'theme.js');

        $this->assertInstanceOf(AssetCollection::class, Assets::collection('scripts'));
        $this->assertEquals(['theme.js' => 'theme.js'], Assets::collection('scripts')->all());
    }

    public function testLoad()
    {
        Assets::load('scripts', 'theme.js');

        $this->assertEquals(['theme.js' => 'theme.js'], Assets::collection('scripts')->all());

        Assets::load('scripts', 'theme.js');

        $this->assertEquals(['theme.js' => 'theme.js'], Assets::collection('scripts')->all());
    }

    public function testRegister()
    {
        Assets::register('theme.js', 'super.js');
        Assets::load('scripts', 'theme.js');

        $this->assertEquals(['super.js' => 'super.js'], Assets::collection('scripts')->all());
    }

    public function testResolve()
    {
        Assets::register('theme.js', 'super.js');
        Assets::register('pack.js', ['super.js', 'another.js']);
        
        Assets::resolve('theme.js');
        Assets::resolve('theme.js');
        
        Assets::resolve('pack.js');

        $this->assertEquals('https://test.com/example.jpg', Assets::resolve('https://test.com/example.jpg'));
        $this->assertEquals(['super.js', 'another.js'], Assets::resolve('pack.js'));
    }

    public function testInline()
    {
        $this->assertEquals('<style media="all" type="text/css" rel="stylesheet">Test testing.css</style>', Assets::inline('vendor/streams/core/tests/testing.css'));

        $this->assertEquals('<script>Test testing.js</script>', Assets::inline('vendor/streams/core/tests/testing.js'));
    }

    public function testContents()
    {
        $this->assertEquals('Test testing.css', Assets::contents('vendor/streams/core/tests/testing.css'));
    }

    public function testUrl()
    {
        $this->assertEquals(URL::to('testing.css'), Assets::url('testing.css'));
    }

    public function testTag()
    {
        $this->assertEquals('<link media="all" type="text/css" rel="stylesheet" href="vendor/streams/core/tests/testing.css"/>', Assets::tag('vendor/streams/core/tests/testing.css'));

        $this->assertEquals('<script src="vendor/streams/core/tests/testing.js"></script>', Assets::tag('vendor/streams/core/tests/testing.js'));
    }
}
