<?php namespace Streams\Platform\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase
{
    protected static $asset;

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/stubs/Asset.php';

        self::$asset = (new Asset())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../resources');
    }

    public function testItCanBeSetUp()
    {
        $asset = self::$asset;

        $asset->setPublish(true)
            ->setDirectory(__DIR__ . '/../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../resources');

        $this->assertTrue(true);
    }

    public function testItCanReturnPathForGroupUsingFileAssets()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.js', 'phpunit::js/foo.js');
        $asset->add(__METHOD__ . '.js', 'phpunit::js/bar.js');

        $expected = 'assets/default/5f54f06e10d5acbdaa3958d22e9772c3.js';
        $actual   = $asset->path(__METHOD__ . '.js');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '91f7035c17cf1e8272518f05a75fbabe';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnPathForGroupUsingGlobAssets()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.js', 'phpunit::js/*');

        $expected = 'assets/default/5dec1b9e5166c16853b36f027afffb5c.js';
        $actual   = $asset->path(__METHOD__ . '.js');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '8aa2c6716a377c30c00da03062b9240a';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnPathForSingleFile()
    {
        $asset = self::$asset;

        $expected = 'assets/default/73601f55a13118eef75581b87b36db45.js';
        $actual   = $asset->path('phpunit::js/bar.js');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnArrayOfPathsForAssetsInGroup()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.js', 'phpunit::js/foo.js');
        $asset->add(__METHOD__ . '.js', 'phpunit::js/bar.js');

        $expected = [
            'assets/default/c8d3a475ec666195c1c49b99966dd454.js',
            'assets/default/73601f55a13118eef75581b87b36db45.js'
        ];
        $actual   = $asset->paths(__METHOD__ . '.js');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLessFilter()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.css', 'phpunit::less/foo.less');

        $expected = 'assets/default/180fea23119adb98454e121f5d7c22fa.css';
        $actual   = $asset->path(__METHOD__ . '.css');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '8762a1cd65143fe8b3c3c8a69f63edd6';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyScssFilter()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.css', 'phpunit::scss/foo.scss');

        $expected = 'assets/default/82aad3845f8ffcd21d6fe858f2d1c2c8.css';
        $actual   = $asset->path(__METHOD__ . '.css');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'cc57a1bf03e290b28bb727e18e7b7413';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyCoffeeFilter()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.js', 'phpunit::coffee/foo.coffee');

        $expected = 'assets/default/ebf96dd7b05f2f12a664ea8f7942ad91.js';
        $actual   = $asset->path(__METHOD__ . '.js');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '984fd2d4cd10f175ac91c88c07cde663';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyEmbedFilter()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.css', 'phpunit::css/embed.css', ['embed']);

        $expected = 'assets/default/5db482d101f5af2c01ffbd184d714cdb.css';
        $actual   = $asset->path(__METHOD__ . '.css');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '5fa5400e6b2dbac7b4d36203039e8d85';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanMinifyJs()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.js', 'phpunit::js/min.js');

        $expected = 'assets/default/a75d3153937fdd286cde9e2e42cfe0af.js';
        $actual   = $asset->path(__METHOD__ . '.js', ['min']);

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '0c5d5f7981ad03eb4f4dbe8341b4076d';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanMinifyCss()
    {
        $asset = self::$asset;

        $asset->add(__METHOD__ . '.css', 'phpunit::css/min.css');

        $expected = 'assets/default/e999582eb0b88b20452aa9721b3fe201.css';
        $actual   = $asset->path(__METHOD__ . '.css', ['min']);

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'a4bac243a55ed51a4628bad9ec8dc418';
        $actual   = md5(file_get_contents($target));

        // Make sure the data written is correct.
        $this->assertEquals($expected, $actual);
    }

    public function testItWillDetermineCssGroupHintFromLessFile()
    {
        $asset = self::$asset;

        $expected = 'assets/default/180fea23119adb98454e121f5d7c22fa.css';
        $actual   = $asset->path('phpunit::less/foo.less');

        $this->assertEquals($expected, $actual);
    }

    public function testItWillDetermineJsGroupHintFromCoffeeFile()
    {
        $asset = self::$asset;

        $expected = 'assets/default/ebf96dd7b05f2f12a664ea8f7942ad91.js';
        $actual   = $asset->path('phpunit::coffee/foo.coffee');

        $this->assertEquals($expected, $actual);
    }
}
