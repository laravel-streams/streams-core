<?php

namespace Streams\Core\Tests\Criteria;

use Streams\Core\Support\Facades\Streams;
use Streams\Core\Criteria\Adapter\FilebaseAdapter;

abstract class FilebaseCriteriaTest extends CriteriaTest
{

    public function test_it_uses_stream_defined_adapter()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'source' => [
                    'adapter' => CustomExamplesFilebaseAdapter::class,
                ],
            ],
        ]);

        $entry = $stream->entries()->testMethod()->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }
}

class CustomExamplesFilebaseAdapter extends FilebaseAdapter
{
    public function testMethod()
    {
        return $this->orderBy('title', 'DESC');
    }
}
