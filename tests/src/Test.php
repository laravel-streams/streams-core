<?php

class Test extends PHPUnit_Framework_TestCase
{
    public function testHelloWorld()
    {
        app('files')->deleteDirectory(__DIR__ . '/../public/');

        $asset = new \Streams\Platform\Asset\Asset();

        $asset
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../public/')
            ->addNamespace('phpunit', __DIR__ . '/../resources/')
            ->add('foo.js', 'phpunit::js/test.js');

        $asset->path('foo.js');

        $this->assertTrue(true);
    }
}
