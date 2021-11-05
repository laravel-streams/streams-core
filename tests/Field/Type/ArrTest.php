<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Field\Value\ArrValue;
use Streams\Core\Support\Facades\Streams;

class ArrTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->array->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToArray()
    {
        $type = Streams::make('testing.litmus')->fields->array->type();

        $array = $type->generate();

        $json = json_encode($array);
        $serial = serialize($array);

        $data = array_combine(array_map(function ($item) {
            return (string) $item;
        }, $array), $array);

        $arrayable = new Entry($data);
        $generic = new \stdClass($data);

        $this->assertSame($array, $type->modify($array));
        $this->assertSame($array, $type->restore($array));

        $this->assertSame($array, $type->modify($json));
        $this->assertSame($array, $type->restore($json));

        $this->assertSame($array, $type->modify($serial));
        $this->assertSame($array, $type->restore($serial));

        $this->assertSame($data, $type->modify($arrayable));
        
        $this->assertNull($type->modify($generic));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(ArrValue::class, $test->expand('array'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsArray($stream->fields->array->type()->generate());
    }
}
