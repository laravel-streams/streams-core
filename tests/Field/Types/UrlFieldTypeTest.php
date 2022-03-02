<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\UrlFieldType;
use Streams\Core\Field\Presenter\UrlPresenter;

class UrlFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_routable()
    {
        $field = new UrlFieldType([
            'stream' => Streams::make('films')
        ]);

        $url = url('testing');

        $this->assertSame($url, $field->cast($url));
    }

    public function test_it_returns_url_value()
    {
        $field = new UrlFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(UrlPresenter::class, $field->decorate(url('testing')));
    }
}
