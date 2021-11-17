<?php

namespace Streams\Core\Tests\Support\Traits;

use ArrayAccess;
use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Field\Value\Value;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Traits\Prototype;

class PrototypeTest extends TestCase
{

    public function test_can_get_attribute()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $this->assertEquals('Ryan', $prototype->getPrototypeAttribute('name'));
        $this->assertEquals(14, $prototype->getPrototypeAttribute('number'));
    }

    public function test_can_set_attribute()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->setPrototypeAttribute('number', 7);

        $this->assertEquals(7, $prototype->number);
    }

    public function test_can_use_accessor_methods()
    {
        $prototype = new TestPrototype([
            'first_name' => 'Ryan',
            'last_name' => 'Thompson',
        ]);

        $this->assertEquals(
            'Ryan Thompson',
            $prototype->getPrototypeAttribute('full_name')
        );
    }

    public function test_can_use_accessor_hooks()
    {
        $prototype = new TestPrototype([
            'first_name' => 'Ryan',
            'last_name' => 'Thompson',
        ]);

        $prototype::macro('getGreetingAttribute', function () {
            return 'Hello ' . $this->first_name;
        });

        $this->assertEquals(
            'Hello Ryan',
            $prototype->getPrototypeAttribute('greeting')
        );
    }

    public function test_can_use_mutator_methods()
    {
        $prototype = new TestPrototype();

        $prototype->setPrototypeAttribute('full_name', 'Ryan Thompson');

        $this->assertEquals('Ryan', $prototype->first_name);
    }

    public function test_can_use_mutator_hooks()
    {
        $prototype = new TestPrototype();

        $prototype::macro('setAgeAttribute', function ($value) {
            $this->birth_year = date('Y') - $value;
        });

        $prototype->age = 33;

        $this->assertEquals(date('Y') - 33, $prototype->birth_year);
    }

    public function test_can_load_attribute_values()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->loadPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
        ]);

        $this->assertTrue($prototype->number === 14);
        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->description === 'Test');
    }

    public function test_can_set_attribute_values()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->setPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
        ]);

        $this->assertNull($prototype->number);
        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->description === 'Test');
    }

    public function test_can_expand_attribute_values()
    {
        $prototype = new TestPrototype();

        $value = $prototype->expandPrototypeAttribute('name');

        $this->assertInstanceOf(Value::class, $value);
    }
}

class TestPrototype
{
    use Prototype;

    protected $__attributes = [
        'name' => 'Original',
        'description' => 'None',
        'price' => 0.0,
        'status' => null,
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function setFullNameAttribute($value)
    {
        list($first, $last) = explode(' ', $value, 2);

        $this->first_name = $first;
        $this->last_name = $last;
    }
}
