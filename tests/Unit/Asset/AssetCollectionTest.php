<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Asset\AssetCollection;
use Anomaly\Streams\Platform\Asset\Facades\Assets;

/**
 * Class AssetManagerTest
 */
class AssetCollectionTest extends TestCase
{

    public function testCollection()
    {
        $this->assertInstanceOf(AssetCollection::class, Assets::collection('test'));
    }

    public function testLoad()
    {
        Assets::register('example', 'streams::testing/example.js');

        $this->assertEquals([
            'streams::testing/example.js' => 'streams::testing/example.js',
        ], Assets::collection('testing')->load('example')->all());

        $this->assertEquals([
            'streams::testing/example.js' => 'streams::testing/example.js',
        ], Assets::collection('testing')->load('example')->load('example')->all());
    }
}
