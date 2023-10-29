<?php

namespace Streams\Core\Tests\Field;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\FieldSchema;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\FieldDecorator;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Decorator\NumberDecorator;

class FieldTest extends CoreTestCase
{
    public function test_it_is_arrayable()
    {
        $this->assertIsArray(Streams::make('films')->fields->get('title')->toArray());
    }

    public function test_it_is_jsonable()
    {
        $this->assertJson(Streams::make('films')->fields->get('title')->toJson());

        $this->assertJson((string) Streams::make('films')->fields->get('title'));
        $this->assertJson(json_encode(Streams::make('films')->fields->get('title')));
    }

    public function test_it_returns_name()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertEquals('Episode Id', $field->name());
    }

    public function test_it_returns_config()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertEquals('increment', $field->config('default'));
    }

    public function test_it_returns_default_value()
    {
        $id = Streams::make('films')->fields->get('episode_id');
        $planets = Streams::make('films')->fields->get('planets');

        $this->assertEquals(8, $id->default($id->config('default')));
        $this->assertEquals([], $planets->default([]));
    }

    public function test_it_throws_exception_if_type_does_not_exist()
    {
        $this->expectException(\Exception::class);

        Streams::build([
            'id' => 'no_such_type',
            'fields' => [
                'test' => [
                    'type' => 'test',
                ],
            ],
        ]);
    }

    public function test_it_casts_values()
    {
        $field = new Field();

        $this->assertSame('Hello World', $field->cast('Hello World'));
    }

    public function test_it_modifies_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertSame(8, $field->modify('8'));

        $field = new Field();

        $this->assertSame('8', $field->modify('8'));
    }

    public function test_it_restores_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertSame(8, $field->restore('8'));

        $field = new Field();

        $this->assertSame('8', $field->restore('8'));
    }

    public function test_it_decorates_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertInstanceOf(NumberDecorator::class, $field->decorate(8));

        $field = new Field();

        $this->assertInstanceOf(FieldDecorator::class, $field->decorate(null));
    }

    public function test_it_returns_schema()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertInstanceOf(FieldSchema::class, $field->schema());

        $field = new Field();

        $this->assertSame(FieldSchema::class, $field->getSchemaName());
    }

    public function test_it_returns_rules()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertSame(['nullable', 'numeric', 'integer', 'required', 'unique'], $field->rules());
    }

    public function test_it_detects_rules()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertTrue($field->isRequired());
        $this->assertTrue($field->hasRule('unique'));
    }

    public function test_it_returns_rule_parameters()
    {
        $field = Streams::make('films')->fields->get('title');

        $this->assertSame(['25'], $field->ruleParameters('max'));
        $this->assertSame('25', $field->ruleParameter('max'));

        $this->assertSame([], $field->ruleParameters('min'));
        $this->assertNull($field->ruleParameter('min'));
    }

    public function test_it_validates_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertTrue($field->validator(25)->passes());
        $this->assertFalse($field->validator('Foo')->passes());

        $field = Streams::make('films')->fields->get('title');

        $this->assertTrue($field->validator(Str::random(20))->passes());
        $this->assertFalse($field->validator(Str::random(30))->passes());
    }

    public function test_it_generates_values()
    {
        $field = new Field();

        $this->assertNotNull($field->generate());

        $field = new Field([
            'config' => [
                'generator' => FieldTestValueGenerator::class,
            ],
        ]);

        $this->assertSame('Hello World', $field->generate());

        $field = new Field([
            'config' => [
                'generator' => FieldTestValueGenerator::class . '@lorem',
            ],
        ]);

        $this->assertSame('Lorem Ipsum', $field->generate());

        $field = new Field([
            'handle' => 'test',
            'config' => [
                'generator' => FieldTestValueGenerator::class . '@handle',
            ],
        ]);

        $this->assertSame('Test Field', $field->generate());
    }
}

class FieldTestValueGenerator
{
    public function __invoke()
    {
        return 'Hello World';
    }

    public function lorem()
    {
        return 'Lorem Ipsum';
    }

    public function handle(Field $field)
    {
        return ucfirst($field->handle) . ' Field';
    }
}
