<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\TimeFieldType;

class TimeFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_strings_to_carbon()
    {
        $field = new TimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = 'Yesterday 9am';

        $this->assertInstanceOf(Carbon::class, $field->cast($value));
        $this->assertInstanceOf(Carbon::class, $field->restore($value));
    }

    public function test_it_stores_time_in_standard_format()
    {
        $field = new TimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('09:00:00', $field->modify('Yesterday 9am'));
    }
}
