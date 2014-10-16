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

        $expected = '91f7035c17cf1e8272518f05a75fbabe';
        $actual   = md5(file_get_contents($target));

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

        $expected = '8aa2c6716a377c30c00da03062b9240a';
        $actual   = md5(file_get_contents($target));

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

        $expected = '8762a1cd65143fe8b3c3c8a69f63edd6';
        $actual   = md5(file_get_contents($target));

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

        $expected = 'cc57a1bf03e290b28bb727e18e7b7413';
        $actual   = md5(file_get_contents($target));

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

        $expected = '984fd2d4cd10f175ac91c88c07cde663';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
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

        $expected = '5fa5400e6b2dbac7b4d36203039e8d85';
        $actual   = md5(file_get_contents($target));

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

        $expected = '0c5d5f7981ad03eb4f4dbe8341b4076d';
        $actual   = md5(file_get_contents($target));

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

        $expected = 'a4bac243a55ed51a4628bad9ec8dc418';
        $actual   = md5(file_get_contents($target));

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
