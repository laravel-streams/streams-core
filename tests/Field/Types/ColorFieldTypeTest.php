<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ColorFieldType;
use Streams\Core\Field\Presenter\ColorPresenter;

class ColorFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_lowercase()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('#ffffff', $field->cast('#FFFFFF'));
        $this->assertSame('#ffffff', $field->modify('#FFFFFF'));
        $this->assertSame('#ffffff', $field->restore('#FFFFFF'));
    }

    public function test_it_returns_color_presenter()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ColorPresenter::class, $field->decorate('#ffffff'));
    }
}
