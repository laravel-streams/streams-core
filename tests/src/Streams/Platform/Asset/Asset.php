<?php namespace Streams\Platform\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanInstantiatedAndSetup()
    {
        $asset = $this->stub();

        $expectedHash = '4fc900835b1d5bb87d38ede0675c3c45';
        $actualHash   = hashify($asset);

        $this->assertEquals($expectedHash, $actualHash);
    }

    public function testItCanReturnPathForGroupUsingFileAssets()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/foo.js');
        $asset->add('foo.js', 'phpunit::js/bar.js');

        $expectedPath = 'assets/default/03537b40fddc0b80bd73b9f0b12fde07.js';
        $actualPath   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = "var foo = 'test';\nvar bar = 'test';";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanReturnPathForGroupUsingGlobAssets()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/*');

        $expectedPath = 'assets/default/3100a94d4f719679d427f1fc94483ec8.js';
        $actualPath   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = "var bar = 'test';\nvar baz = 'test';\nvar foo = 'test';";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanReturnPathForSingleFile()
    {
        $asset = $this->stub();

        $expectedPath = 'assets/default/a82d831a8caa0615bfb9b8f57b289ca5.js';
        $actualPath   = $asset->path('phpunit::js/bar.js');

        $this->assertEquals($expectedPath, $actualPath);
    }

    public function testItCanReturnArrayOfPathsForAssetsInGroup()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/foo.js');
        $asset->add('foo.js', 'phpunit::js/bar.js');

        $expectedPaths = [
            'assets/default/19a70b6086289e862512cd9b88956a97.js',
            'assets/default/a82d831a8caa0615bfb9b8f57b289ca5.js'
        ];
        $actualPaths   = $asset->paths('foo.js');

        $this->assertEquals($expectedPaths, $actualPaths);
    }

    public function testItCanApplyLessFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::less/foo.less');

        $expectedPath = 'assets/default/8167893471bf8c4583d596773ffa515f.css';
        $actualPath   = $asset->path('foo.css');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = ".test {\n  color: #ffffff;\n}\n";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanApplyScssFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::scss/foo.scss');

        $expectedPath = 'assets/default/095d98064422583c2a634bd6c7249923.css';
        $actualPath   = $asset->path('foo.css');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = ".test {\n  color: #fff; }\n";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanApplyCoffeeFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::coffee/foo.coffee');

        $expectedPath = 'assets/default/02b1c449a97928a6d884197ae2b8b646.js';
        $actualPath   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $actualData = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertTrue(str_contains($actualData, 'alert("You da foo!");'));
    }

    protected function stub()
    {
        return (new \Streams\Platform\Asset\Asset())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../../../resources');
    }
}
