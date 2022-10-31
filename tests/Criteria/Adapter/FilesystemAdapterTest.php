<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Streams\Core\Support\Facades\Streams;
use Streams\Core\Tests\Criteria\CriteriaTest;
use Streams\Core\Criteria\Adapter\SelfAdapter;

class FilesystemAdapterTest extends CriteriaTest
{
    
    protected function setUp():void
    {
        parent::setUp();

        Streams::extend('films', [
            'config' => [
                'source' => [
                    'type' => 'filesystem',
                ],
            ],
        ]);
    }

    public function test_it_uses_stream_defined_adapter()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'source' => [
                    'type' => 'self',
                    'adapter' => CustomExamplesSelfAdapter::class,
                ],
            ],
        ]);

        $entry = $stream->entries()->testMethod()->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    protected function removeData()
    {
        $json = json_decode(base_path('streams/films.json'), true);
        
        unset($json['data']);

        file_put_contents(base_path('streams/films.json'), json_encode($json, JSON_PRETTY_PRINT));
    }
}

class CustomExamplesSelfAdapter extends SelfAdapter
{
    public function testMethod()
    {
        return $this->orderBy('title', 'DESC');
    }
}
