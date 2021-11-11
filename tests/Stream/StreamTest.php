<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Entry\EntryFactory;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Validation\Validator;
use Streams\Core\Repository\Contract\RepositoryInterface;

class StreamTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(__DIR__ . '/../litmus.json');
    }

    public function test_is_arrayable()
    {
        $this->assertIsArray(Streams::make('testing.litmus')->toArray());
    }

    public function test_is_jsonable()
    {
        $this->assertJson(Streams::make('testing.litmus')->toJson());
        $this->assertJson((string) Streams::make('testing.litmus'));
    }

    public function test_can_return_entry_criteria()
    {
        $this->assertInstanceOf(Criteria::class, Streams::entries('testing.litmus'));
    }

    public function test_can_return_entry_repository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, Streams::repository('testing.litmus'));
    }

    public function test_can_return_entry_factory()
    {
        $this->assertInstanceOf(EntryFactory::class, Streams::factory('testing.litmus'));
    }

    public function test_can_return_validator()
    {
        $this->assertInstanceOf(Validator::class, Streams::make('testing.litmus')->validator([]));
    }

    public function test_can_check_if_field_has_a_rule()
    {
        $stream = Streams::make('testing.litmus');

        $this->assertTrue($stream->hasRule('number', 'min'));
        $this->assertFalse($stream->hasRule('number', 'max'));
        $this->assertTrue($stream->hasRule('uuid', 'required'));
    }

    public function test_can_get_field_rule()
    {
        $stream = Streams::make('testing.litmus');

        $this->assertNull($stream->getRule('integer', 'min'));
        $this->assertEquals('max:100', $stream->getRule('integer', 'max'));
    }

    public function test_can_get_field_rule_parameters()
    {
        $stream = Streams::make('testing.litmus');

        $this->assertEquals(['10'], $stream->ruleParameters('number', 'min'));
        $this->assertEquals('10', $stream->ruleParameter('number', 'min'));
        $this->assertNull($stream->ruleParameter('number', 'max'));

        $this->assertEquals(['100'], $stream->ruleParameters('integer', 'max'));
        $this->assertEquals('100', $stream->ruleParameter('integer', 'max'));
        $this->assertNull($stream->ruleParameter('integer', 'min'));
    }
    
    public function test_can_check_if_field_is_required()
    {
        $stream = Streams::make('testing.litmus');

        $this->assertTrue($stream->isRequired('uuid'));
        $this->assertFalse($stream->isRequired('integer'));
    }
}
