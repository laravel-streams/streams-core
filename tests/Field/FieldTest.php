<?php

namespace Streams\Core\Tests\Field;

use Streams\Core\Field\FieldSchema;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\IntegerValue;

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
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertSame(8, $field->cast('8'));
    }

    public function test_it_modifies_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertSame(8, $field->modify('8'));
    }

    public function test_it_restores_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertSame(8, $field->restore('8'));
    }

    public function test_it_decorates_values()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertInstanceOf(IntegerValue::class, $field->decorate(8));
    }

    public function test_it_returns_schema()
    {
        $field = Streams::make('films')->fields->get('episode_id');

        $this->assertInstanceOf(FieldSchema::class, $field->schema());
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
}
