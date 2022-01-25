<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\MultiselectValue;

class MultiselectFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_modifies_to_selection_array()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect;

        $this->assertSame(['foo'], $type->modify('foo'));
        $this->assertSame(['bar'], $type->restore('bar'));

        $array = $type->generate();

        $this->assertSame($array, $type->modify($array));
    }

    public function test_restores_to_selection_array()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect;

        $this->assertSame(['bar'], $type->restore('bar'));

        $array = $type->generate();

        $json = json_encode($array);
        $serial = serialize($array);

        $data = array_combine(array_map(function ($item) {
            return (string) $item;
        }, $array), $array);

        $arrayable = new Collection($data);

        $this->assertSame($array, $type->restore($array));

        $this->assertSame($array, $type->restore($json));

        $this->assertSame($array, $type->restore($serial));
    }

    public function test_configured_options()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect;

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $type->options());
    }

    public function test_callable_options()
    {
        $type = Streams::make('testing.litmus')->fields->multiselect_callable_options;

        $this->assertSame(['foo' => 'Bar', 'bar' => 'Baz'], $type->options());
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(MultiselectValue::class, $test->expand('multiselect'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertSame([], array_diff(
            $stream->fields->multiselect->generate(),
            array_keys($stream->fields->multiselect->options())
        ));
    }
}
