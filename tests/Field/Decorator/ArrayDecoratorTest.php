<?php

namespace Streams\Core\Tests\Field\Decorator;

use Illuminate\Support\Collection;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Types\ArrayFieldType;

class ArrayDecoratorTest extends CoreTestCase
{
    public function test_it_returns_collections()
    {
        $decorator = (new ArrayFieldType())->decorate(['#f00']);

        $this->assertInstanceOf(Collection::class, $decorator->collect());
    }

    public function test_it_returns_array_as_html_attributes()
    {
        $decorator = (new ArrayFieldType())->decorate(['name' => 'test']);

        $this->assertSame('name="test"', $decorator->htmlAttributes());
    }

    public function test_it_passes_through_to_object_wrappers()
    {
        $decorator = (new ArrayFieldType())->decorate(collect(['name' => 'test']));

        $this->assertSame('test', $decorator->first());
    }

    public function test_it_maps_calls_to_array_helper()
    {
        $decorator = (new ArrayFieldType())->decorate(['name' => 'test']);

        $this->assertSame('test', $decorator->first());
    }

    public function test_it_throws_exceptions_for_unknown_calls()
    {
        $decorator = (new ArrayFieldType())->decorate(['name' => 'test']);

        $this->expectException(\Exception::class);

        $this->assertSame('test', $decorator->foo());
    }
}
