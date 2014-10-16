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

        $expectedPath = 'assets/default/dc18d69792b0688674e2ca9d5b3b71f4.js';
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

        $expectedPath = 'assets/default/726adbae16e6939ee0748a571fe991f5.js';
        $actualPath   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = "var bar = 'test';\nvar baz = 'test';\nvar foo = 'test';\nvar foo = 'test';\n\nvar bar = 'test';";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanReturnPathForSingleFile()
    {
        $asset = $this->stub();

        $expectedPath = 'assets/default/b15baae36b061d011772b1bc59b5a7c8.js';
        $actualPath   = $asset->path('phpunit::js/bar.js');

        $this->assertEquals($expectedPath, $actualPath);
    }

    public function testItCanReturnArrayOfPathsForAssetsInGroup()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/foo.js');
        $asset->add('foo.js', 'phpunit::js/bar.js');

        $expectedPaths = [
            'assets/default/9a95bd079119905f14c46bba8af3713f.js',
            'assets/default/b15baae36b061d011772b1bc59b5a7c8.js'
        ];
        $actualPaths   = $asset->paths('foo.js');

        $this->assertEquals($expectedPaths, $actualPaths);
    }

    public function testItCanApplyLessFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::less/foo.less');

        $expectedPath = 'assets/default/7dae38e5d1a8f20fcf2eed9d62a08009.css';
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

        $expectedPath = 'assets/default/513c4bcabd16d748a69f00ee3a526271.css';
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

        $expectedPath = 'assets/default/7088e446fb31fdcbbbef2f6f1e06ac17.js';
        $actualPath   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $actualData = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertTrue(str_contains($actualData, 'alert("You da foo!");'));
    }

    public function testItCanApplyEmbedFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::css/embed.css', ['embed']);

        $expectedPath = 'assets/default/fa2b73bc4bdb00caafca7407cbb0fffe.css';
        $actualPath   = $asset->path('foo.css');

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = ".test {\n    background: url(data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABkAAD/4QMtaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTQwQjdGMDM0RDY2MTFFNEIyQjlBNDQ5NDBGMDEyMEEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTQwQjdGMDQ0RDY2MTFFNEIyQjlBNDQ5NDBGMDEyMEEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1NDBCN0YwMTRENjYxMUU0QjJCOUE0NDk0MEYwMTIwQSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1NDBCN0YwMjRENjYxMUU0QjJCOUE0NDk0MEYwMTIwQSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pv/uAA5BZG9iZQBkwAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAgEBAgICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIAAoACgMBEQACEQEDEQH/xABNAAEBAAAAAAAAAAAAAAAAAAAACQEBAQEAAAAAAAAAAAAAAAAAAAkKEAEAAAAAAAAAAAAAAAAAAAAAEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCMKU7f4AAA/9k=);\n}";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanMinifyJs()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/min.js');

        $expectedPath = 'assets/default/9f0d7e77394c4044a651f1c9bf1460f5.js';
        $actualPath   = $asset->path('foo.js', ['min']);

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = "var foo='test';var bar='test';";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItCanMinifyCss()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::css/min.css');

        $expectedPath = 'assets/default/2a5b05b144e03b1bbf17656790e618b4.css';
        $actualPath   = $asset->path('foo.css', ['min']);

        // Make sure the path is correct.
        $this->assertEquals($expectedPath, $actualPath);

        $target = __DIR__ . '/../../../../public/' . $expectedPath;

        $expectedData = ".color{color:#ffffff}";
        $actualData   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expectedData, $actualData);
    }

    public function testItWillDetermineCssGroupHintFromLessFile()
    {
        $asset = $this->stub();

        $expectedPath = 'assets/default/7dae38e5d1a8f20fcf2eed9d62a08009.css';
        $actualPath   = $asset->path('phpunit::less/foo.less');

        $this->assertEquals($expectedPath, $actualPath);
    }

    public function testItWillDetermineJsGroupHintFromCoffeeFile()
    {
        $asset = $this->stub();

        $expectedPath = 'assets/default/7088e446fb31fdcbbbef2f6f1e06ac17.js';
        $actualPath   = $asset->path('phpunit::coffee/foo.coffee');

        $this->assertEquals($expectedPath, $actualPath);
    }

    protected function stub()
    {
        return (new \Streams\Platform\Asset\Asset())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../../../resources');
    }
}
