<?php

class Test extends PHPUnit_Framework_TestCase
{
    public function testHelloWorld()
    {
        $asset = new \Streams\Platform\Asset\Asset();

        $asset
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../public/assets/')
            ->addNamespace('tests', __DIR__ . '/../resources/')
            ->add('foo.js', 'js/test.js');

        $asset->path('foo.js');

        $this->assertTrue(true);
    }
}
