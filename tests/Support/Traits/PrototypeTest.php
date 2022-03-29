<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Field\Field;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Field\FieldDecorator;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Field\Value\IntegerValue;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Field\Decorator\UrlDecorator;

class PrototypeTest extends CoreTestCase
{

    public function test_it_has_access_to_attributes()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $this->assertEquals('localhost', $prototype->url);

        $this->assertEquals('localhost', $prototype->getPrototypeAttribute('url'));
        $this->assertEquals('Ryan', $prototype->getPrototypeAttribute('name'));
        $this->assertEquals(14, $prototype->getPrototypeAttribute('number'));
    }

    public function test_it_affirms_attributes()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
        ]);

        $this->assertTrue($prototype->hasPrototypeAttribute('url'));
        $this->assertTrue($prototype->hasPrototypeAttribute('name'));
        $this->assertFalse($prototype->hasPrototypeAttribute('number'));
    }

    public function test_it_sets_attribute()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->setPrototypeAttribute('number', 7);
        $prototype->setPrototypeAttribute('url', '127.0.0.1:8000');

        $this->assertEquals(7, $prototype->number);
        $this->assertEquals('127.0.0.1:8000', $prototype->url);
    }

    public function test_it_supports_accessor_methods()
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

    public function test_it_supports_accessor_hooks()
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

    public function test_it_supports_mutator_methods()
    {
        $prototype = new TestPrototype();

        $prototype->setPrototypeAttribute('full_name', 'Ryan Thompson');

        $this->assertEquals('Ryan', $prototype->first_name);
    }

    public function test_it_supports_mutator_hooks()
    {
        $prototype = new TestPrototype();

        $prototype::macro('setAgeAttribute', function ($value) {
            $this->birth_year = date('Y') - $value;
        });

        $prototype->age = 33;

        $this->assertEquals(date('Y') - 33, $prototype->birth_year);
    }

    public function test_it_loads_attribute_values()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->loadPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
            'url' => '127.0.0.1:8000',
        ]);

        $this->assertTrue($prototype->number === 14);
        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->description === 'Test');
        $this->assertTrue($prototype->url === '127.0.0.1:8000');
    }

    public function test_it_returns_original_attribute_values()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->loadPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
            'url' => '127.0.0.1:8000',
        ]);

        $original = $prototype->getOriginalPrototypeAttributes();

        $this->assertSame([
            'name' => 'Ryan',
            'description' => 'None',
            'price' => 0.0,
            'status' => null,
            'number' => 14,
            'url' => 'localhost',
        ], $original);
    }

    public function test_it_supports_setting_all_attributes_at_once()
    {
        $prototype = new TestPrototype([
            'name' => 'Ryan',
            'number' => 14,
        ]);

        $prototype->setPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
            'url' => '127.0.0.0:8000',
        ]);

        $this->assertNull($prototype->number);
        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->description === 'Test');
        $this->assertTrue($prototype->url === '127.0.0.0:8000');
    }

    public function test_it_decorates_attribute_values()
    {
        $prototype = new TestPrototype([
            'name' => 'Test',
        ]);

        $name = $prototype->decoratePrototypeAttribute('name');
        $url = $prototype->decoratePrototypeAttribute('url');

        $this->assertInstanceOf(FieldDecorator::class, $name);
        $this->assertInstanceOf(UrlDecorator::class, $url);
    }

    public function test_it_supports_decorate_hooks()
    {
        $prototype = new TestPrototype([
            'test' => 'Test',
        ]);

        $prototype::macro('decorateTestAttribute', function ($value) {
            return new CustomValue($value);
        });

        $value = $prototype->decoratePrototypeAttribute('test');

        $this->assertInstanceOf(CustomValue::class, $value);
    }

    public function test_it_guesses_undefined_attribute_types()
    {
        $prototype = new TestPrototype([
            'name' => null,
            'number' => 14,
            'double' => 14.1,
        ]);

        $name = $prototype->decoratePrototypeAttribute('name');
        $double = $prototype->decoratePrototypeAttribute('double');
        $number = $prototype->decoratePrototypeAttribute('number');

        $this->assertInstanceOf(StrValue::class, $name);
        $this->assertInstanceOf(NumberValue::class, $double);
        $this->assertInstanceOf(IntegerValue::class, $number);
    }

    public function test_it_sets_prototype_properties()
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

    public function test_it_returns_prototype_properties()
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

        $this->assertSame([
            'type' => 'boolean',
        ], $prototype->getPrototypeProperty('name'));
    }

    public function test_it_trims_undefined_prototype_attributes()
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

    #[Field([
        'type' => 'url',
    ])]
    public string $url = 'localhost';

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

class CustomValue
{
    public function upper()
    {
        return strtoupper($this->value);
    }
}
