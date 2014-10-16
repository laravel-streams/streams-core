<?php namespace Streams\Platform\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanReturnPathForGroupUsingFileAssets()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/foo.js');
        $asset->add('foo.js', 'phpunit::js/bar.js');

        $expected = 'assets/default/dc18d69792b0688674e2ca9d5b3b71f4.js';
        $actual   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = "var foo = 'test';\nvar bar = 'test';";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnPathForGroupUsingGlobAssets()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/*');

        $expected = 'assets/default/726adbae16e6939ee0748a571fe991f5.js';
        $actual   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = "var bar = 'test';\nvar baz = 'test';\nvar foo = 'test';\nvar foo = 'test';\n\nvar bar = 'test';";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnPathForSingleFile()
    {
        $asset = $this->stub();

        $expected = 'assets/default/b15baae36b061d011772b1bc59b5a7c8.js';
        $actual   = $asset->path('phpunit::js/bar.js');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnArrayOfPathsForAssetsInGroup()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/foo.js');
        $asset->add('foo.js', 'phpunit::js/bar.js');

        $expected = [
            'assets/default/9a95bd079119905f14c46bba8af3713f.js',
            'assets/default/b15baae36b061d011772b1bc59b5a7c8.js'
        ];
        $actual   = $asset->paths('foo.js');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLessFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::less/foo.less');

        $expected = 'assets/default/7dae38e5d1a8f20fcf2eed9d62a08009.css';
        $actual   = $asset->path('foo.css');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = ".test {\n  color: #ffffff;\n}\n";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyScssFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::scss/foo.scss');

        $expected = 'assets/default/513c4bcabd16d748a69f00ee3a526271.css';
        $actual   = $asset->path('foo.css');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = ".test {\n  color: #fff; }\n";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyCoffeeFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::coffee/foo.coffee');

        $expected = 'assets/default/7088e446fb31fdcbbbef2f6f1e06ac17.js';
        $actual   = $asset->path('foo.js');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $actual = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertTrue(str_contains($actual, 'alert("You da foo!");'));
    }

    public function testItCanApplyEmbedFilter()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::css/embed.css', ['embed']);

        $expected = 'assets/default/fa2b73bc4bdb00caafca7407cbb0fffe.css';
        $actual   = $asset->path('foo.css');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = ".test {\n    background: url(data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABkAAD/4QMtaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTQwQjdGMDM0RDY2MTFFNEIyQjlBNDQ5NDBGMDEyMEEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTQwQjdGMDQ0RDY2MTFFNEIyQjlBNDQ5NDBGMDEyMEEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1NDBCN0YwMTRENjYxMUU0QjJCOUE0NDk0MEYwMTIwQSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1NDBCN0YwMjRENjYxMUU0QjJCOUE0NDk0MEYwMTIwQSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pv/uAA5BZG9iZQBkwAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAgEBAgICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIAAoACgMBEQACEQEDEQH/xABNAAEBAAAAAAAAAAAAAAAAAAAACQEBAQEAAAAAAAAAAAAAAAAAAAkKEAEAAAAAAAAAAAAAAAAAAAAAEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCMKU7f4AAA/9k=);\n}";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanMinifyJs()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/min.js');

        $expected = 'assets/default/9f0d7e77394c4044a651f1c9bf1460f5.js';
        $actual   = $asset->path('foo.js', ['min']);

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = "var foo='test';var bar='test';";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanMinifyCss()
    {
        $asset = $this->stub();

        $asset->add('foo.css', 'phpunit::css/min.css');

        $expected = 'assets/default/2a5b05b144e03b1bbf17656790e618b4.css';
        $actual   = $asset->path('foo.css', ['min']);

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = ".color{color:#ffffff}";
        $actual   = file_get_contents($target);

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItWillDetermineCssGroupHintFromLessFile()
    {
        $asset = $this->stub();

        $expected = 'assets/default/7dae38e5d1a8f20fcf2eed9d62a08009.css';
        $actual   = $asset->path('phpunit::less/foo.less');

        $this->assertEquals($expected, $actual);
    }

    public function testItWillDetermineJsGroupHintFromCoffeeFile()
    {
        $asset = $this->stub();

        $expected = 'assets/default/7088e446fb31fdcbbbef2f6f1e06ac17.js';
        $actual   = $asset->path('phpunit::coffee/foo.coffee');

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return (new \Streams\Platform\Asset\Asset())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../../../resources');
    }
}
