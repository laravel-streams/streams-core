<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Validation\Validator;
use Streams\Core\Repository\Contract\RepositoryInterface;

class StreamTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            'handle' => 'testing.widgets',
            'source' => [
                'path' => 'vendor/streams/core/tests/data/widgets',
                'format' => 'json',
            ],
            'rules' => [
                'name' => 'required|widget_validator'
            ],
            'validators' => [
                'widget_validator' => [
                    'handler' => 'Streams\Core\Tests\Stream\WidgetValidator@handle',
                    'message' => 'Testing message',
                ],
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testSupportInterfaces()
    {
        $this->assertIsArray(Streams::make('testing.examples')->toArray());
        $this->assertJson(Streams::make('testing.examples')->toJson());
        $this->assertJson((string) Streams::make('testing.examples'));
    }

    public function testCanReturnEntryCriteria()
    {
        $this->assertInstanceOf(
            Criteria::class,
            Streams::make('testing.examples')->entries()
        );
    }

    public function testCanReturnEntryRepository()
    {
        $this->assertInstanceOf(
            RepositoryInterface::class,
            Streams::make('testing.examples')->repository()
        );
    }

    public function testStreamFactoryMethod()
    {
        $this->assertInstanceOf(
            EntryFactory::class,
            Streams::make('testing.fakers')->factory()
        );
    }

    public function testStreamValidator()
    {
        $this->assertInstanceOf(
            Validator::class,
            Streams::make('testing.examples')->validator([])
        );

        $this->assertFalse(Streams::make('testing.examples')->validator([])->passes());
        $this->assertTrue(Streams::make('testing.examples')->validator(['name' => 'First Example'])->passes());

        $entry = Streams::entries('testing.examples')->first();

        // Fails on ExampleValidator below
        $this->assertTrue(Streams::make('testing.examples')->validator($entry)->passes());

        $entry->name = 'No';
        
        $this->assertFalse(Streams::make('testing.examples')->validator($entry)->passes());
        
        $entry = Streams::entries('testing.widgets')->first();

        // Fails on WidgetsValidator below
        // $this->assertTrue(Streams::make('testing.widgets')->validator($entry)->passes());

        // $entry->name = 'Test';

        // $this->assertFalse(Streams::make('testing.widgets')->validator($entry)->passes());
    }

    public function testRuleAccessors()
    {
        $stream = Streams::make('testing.examples');

        $this->assertTrue($stream->hasRule('name', 'required'));
        $this->assertTrue($stream->hasRule('name', 'min'));

        $this->assertNull($stream->getRule('name', 'max'));
        $this->assertEquals('min:3', $stream->getRule('name', 'min'));
        
        $this->assertEquals(['3'], $stream->ruleParameters('name', 'min'));
        $this->assertEquals([], $stream->ruleParameters('name', 'max'));
        $this->assertEquals([], $stream->ruleParameters('age', 'min'));
        
        $this->assertTrue($stream->isRequired('name'));
        $this->assertFalse($stream->isRequired('age'));
    }

    // public function testHtmlAttributes()
    // {
    //     $name = Streams::make('testing.examples');
        
    //     $name->htmlAttributes();
    // }
}

class WidgetValidator
{

    public function handle($attribute, $value)
    {
        return Str::startsWith($value, 'First');
    }
}
