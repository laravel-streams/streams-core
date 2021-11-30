<?php

namespace Streams\Core\Tests\Field\Type;

use Illuminate\Contracts\Support\Arrayable;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\Prototype;

class PrototypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function test_restores_to_instance()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(ExampleAbstract::class, $test->object);
    }

    public function test_expands_to_instance()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame('bar', $test->expand('object')->foo);
    }

    public function test_modifies_to_attributes()
    {
        $type = Streams::make('testing.litmus')->fields->object->type();

        $this->assertSame(['foo' => 'Bar'], $type->modify(new ExampleAbstract(['foo' => 'Bar'])));
    }
}

class ExampleAbstract implements Arrayable
{
    use Prototype;

    public function toArray(): array
    {
        return Hydrator::dehydrate($this, [
            '__observers',
            '__listeners',
        ]);
    }
}
