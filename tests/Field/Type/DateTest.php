<?php

namespace Streams\Core\Tests\Field\Type;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class DateTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->date->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToDatime()
    {
        $type = Streams::make('testing.litmus')->fields->date->type();

        $date = '2021-01-01';
        $value = '2021-01-01 9:30';
        $standard = '2021-01-01 09:30:00';
        $carbon = new Carbon($standard);
        $instance = new \DateTime($standard);

        $timestamp = $carbon->timestamp;

        $this->assertSame($carbon->format('Y-m-d'), $type->modify($carbon));
        $this->assertSame($carbon->format('Y-m-d'), $type->modify($instance));
        $this->assertSame($carbon->format('Y-m-d'), $type->modify($timestamp));

        $this->assertSame($date, $type->restore($date)->format('Y-m-d'));
        $this->assertSame($date, $type->restore($value)->format('Y-m-d'));
        $this->assertSame($date, $type->restore($standard)->format('Y-m-d'));

        $yesterday = new Carbon('Yesterday 9am');

        $this->assertInstanceOf(Carbon::class, $type->restore('Yesterday 9am'));
        $this->assertSame($yesterday->format('Y-m-d'), $type->modify($yesterday));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(DatetimeValue::class, $test->expand('date'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertInstanceOf(\DateTime::class, $stream->fields->date->type()->generate());
    }
}
