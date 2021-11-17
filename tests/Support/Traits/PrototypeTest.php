<?php

namespace Streams\Core\Tests\Support\Traits;

use ArrayAccess;
use Carbon\Carbon;
use Streams\Core\Field\Value\IntegerValue;
use Tests\TestCase;
use Streams\Core\Field\Value\Value;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Field\Value\StrValue;
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

    public function test_can_affirm_attribute()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
        ]);

        $this->assertTrue($prototype->hasPrototypeAttribute('name'));
        $this->assertFalse($prototype->hasPrototypeAttribute('number'));
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

    public function test_can_return_original_attribute_values()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->loadPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
        ]);

        $original = $prototype->getOriginalPrototypeAttributes();

        $this->assertSame([
            'name' => 'Ryan',
            'number' => 14,
        ], $original);
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
        $prototype = new TestPrototype([
            'name' => 'Test',
        ]);

        $value = $prototype->expandPrototypeAttribute('name');

        $this->assertInstanceOf(Value::class, $value);
    }

    public function test_can_use_expand_hooks()
    {
        $prototype = new TestPrototype([
            'test' => 'Test',
        ]);

        $prototype::macro('expandTestAttribute', function ($value) {
            return new CustomValue($value);
        });

        $value = $prototype->expandPrototypeAttribute('test');

        $this->assertInstanceOf(CustomValue::class, $value);
    }

    public function test_can_guess_attribute_types()
    {
        $prototype = new TestPrototype([
            'name' => null,
            'number' => 14,
            'double' => 14.1,
        ]);

        $name = $prototype->expandPrototypeAttribute('name');
        $double = $prototype->expandPrototypeAttribute('double');
        $number = $prototype->expandPrototypeAttribute('number');

        $this->assertInstanceOf(StrValue::class, $name);
        $this->assertInstanceOf(NumberValue::class, $double);
        $this->assertInstanceOf(IntegerValue::class, $number);
    }

    public function test_can_set_prototype_properties()
    {
        $prototype = new TestPrototype();

        $prototype->setPrototypeProperties([
            'name' => [
                'type' => 'boolean',
            ]
        ]);

        $prototype->loadPrototypeAttributes([
            'name' => 'Ryan',
        ]);

        $this->assertIsBool($prototype->getPrototypeAttribute('name'));
    }

    public function test_can_get_prototype_properties()
    {
        $prototype = new TestPrototype();

        $prototype->setPrototypeProperties([
            'name' => [
                'type' => 'boolean',
            ]
        ]);

        $this->assertSame([
            'name' => [
                'type' => 'boolean',
            ]
        ], $prototype->getPrototypeProperties());
    }

    public function test_can_get_specific_prototype_property()
    {
        $prototype = new TestPrototype();

        $prototype->setPrototypeProperties([
            'name' => [
                'type' => 'boolean',
            ]
        ]);

        $this->assertSame([
            'type' => 'boolean',
        ], $prototype->getPrototypeProperty('name'));
    }

    public function test_can_trim_undefined_prototype_attributes()
    {
        $prototype = new TestPrototype();

        $prototype->setPrototypeAttributes([
            'name' => 'Ryan',
            'number' => 10,
        ]);

        $this->assertSame([
            'name' => 'Ryan',
            'number' => 10,
        ], $prototype->getPrototypeAttributes());

        $prototype->setPrototypeProperties([
            'name' => [
                'type' => 'string',
            ]
        ]);

        $prototype->trimUndefinedPrototypeAttributes();

        $this->assertSame([
            'name' => 'Ryan',
        ], $prototype->getPrototypeAttributes());
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

class CustomValue extends Value
{
    public function upper()
    {
        return strtoupper($this->value);
    }
}
