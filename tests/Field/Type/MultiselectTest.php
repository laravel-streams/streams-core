<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\MultiselectValue;

class MultiselectTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToSelectionArray()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect->type();

        $this->assertSame(['foo'], $type->modify('foo'));
        $this->assertSame(['bar'], $type->restore('bar'));

        $array = $type->generate();

        $json = json_encode($array);
        $serial = serialize($array);

        $data = array_combine(array_map(function ($item) {
            return (string) $item;
        }, $array), $array);

        $arrayable = new Collection($data);

        $this->assertSame($array, $type->modify($array));
        $this->assertSame($array, $type->restore($array));

        $this->assertSame($array, $type->modify($json));
        $this->assertSame($array, $type->restore($json));

        $this->assertSame($array, $type->modify($serial));
        $this->assertSame($array, $type->restore($serial));

        $this->assertSame($data, $type->modify($arrayable));
    }

    public function testConfiguredOptions()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect->type();

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $type->options());
    }

    public function testCallableOptions()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect_callable_options->type();

        $this->assertSame(['foo' => 'Bar', 'bar' => 'Baz'], $type->options());
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(MultiselectValue::class, $test->expand('multiselect'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertSame([], array_diff(
            $stream->fields->multiselect->type()->generate(),
            array_keys($stream->fields->multiselect->type()->options())
        ));
    }
}


class MultiselectHandler
{

    public function handle(): array
    {
        return ['foo' => 'Bar', 'bar' => 'Baz'];
    }
}
