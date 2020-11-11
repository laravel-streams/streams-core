<?php

namespace Streams\Core\Tests\Stream;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Collection;
use Streams\Core\Criteria\Contract\CriteriaInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Tests\TestCase;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

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
                'name' => 'required|example_validator'
            ],
            'validators' => [
                'example_validator' => [
                    'handler' => 'Streams\Core\Tests\Stream\TestValidator@handle',
                    'message' => 'Testing message',
                ],
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testSupportInterfaces()
    {
        $this->assertIsArray(Streams::make('testing.examples')->toArray());
        $this->assertJson(Streams::make('testing.examples')->toJson());
        $this->assertJson((string) Streams::make('testing.examples'));
    }

    public function testCanReturnEntryCriteria()
    {
        $this->assertInstanceOf(CriteriaInterface::class, Streams::make('testing.examples')->entries());
    }

    public function testCanReturnEntryRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, Streams::make('testing.examples')->repository());
    }

    public function testStreamValidator()
    {
        $this->assertInstanceOf(Validator::class, Streams::make('testing.examples')->validator([]));

        $this->assertFalse(Streams::make('testing.examples')->validator([])->passes());
        $this->assertTrue(Streams::make('testing.examples')->validator(['name' => 'First Example'])->passes());

        $entry = Streams::entries('testing.examples')->first();

        // Fails on TestValidator below
        $this->assertTrue(Streams::make('testing.examples')->validator($entry)->passes());

        $entry->name = 'Test';

        $this->assertFalse(Streams::make('testing.examples')->validator($entry)->passes());

        $entry = Streams::entries('testing.widgets')->first();

        // Fails on TestValidator below
        $this->assertTrue(Streams::make('testing.widgets')->validator($entry)->passes());

        $entry->name = 'Test';

        $this->assertFalse(Streams::make('testing.widgets')->validator($entry)->passes());
    }
}

class ExampleValidator
{

    public function validate($attribute, $value)
    {
        return strpos($value, 'First') > -1;
    }
}

class TestValidator
{

    public function handle($attribute, $value)
    {
        return strpos($value, 'First') > -1;
    }
}
