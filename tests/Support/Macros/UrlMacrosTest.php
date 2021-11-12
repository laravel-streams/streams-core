<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use Streams\Core\Support\Facades\Streams;

class UrlMacrosTest extends TestCase
{

    public function test_can_generate_url_strings()
    {
        $stream = Streams::register([
            'id' => 'testing.url_macros',
            'routes' => [
                'view' => 'testing/macros/{id}'
            ],
            'fields' => [
                'id' => 'uuid',
            ],
        ]);

        $entry = $stream->factory()->create();

        $this->assertSame(
            env('APP_URL') . '/testing/macros/' . $entry->id,
            URL::streams('streams::testing.url_macros.view', $entry)
        );

        $this->assertSame(
            env('APP_URL') . '/foo/bar',
            URL::streams('foo/bar', $entry)
        );
    }
}
