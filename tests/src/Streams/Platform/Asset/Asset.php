<?php namespace Streams\Platform\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanInstantiatedAndSetup()
    {
        $asset = $this->stub();

        $this->assertEquals('Streams\Platform\Asset\Asset', get_class($asset));
    }

    public function testItCanPublishASingleFile()
    {
        $asset = $this->stub();

        $asset->add('foo.js', 'phpunit::js/foo.js');

        $this->assertEquals('assets/default/7f12f8d975916098a1b891fecbcea629.js', $asset->path('foo.js'));
    }

    protected function stub()
    {
        return (new \Streams\Platform\Asset\Asset())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../public/')
            ->addNamespace('phpunit', __DIR__ . '/../resources/');
    }
}
