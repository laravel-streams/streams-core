<?php

namespace Streams\Core\Tests\Field;

use Streams\Core\Field\Field;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;

class FieldCollectionTest extends CoreTestCase
{

    public function test_it_maps_handles_to_property_access()
    {
        $this->assertInstanceOf(
            Field::class,
            Streams::make('films')->fields->episode_id
        );
    }

    public function test_it_returns_required_fields()
    {
        $this->assertEquals(
            2,
            Streams::make('films')->fields->required()->count()
        );
    }
}
