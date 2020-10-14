<?php

use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\File;

/**
 * Class StreamsTestCase
 */
class StreamsTestCase extends \Orchestra\Testbench\TestCase
{
    use \Helmich\JsonAssert\JsonAssertions;

    /**
     * @var string
     */
    protected $streamsPath = __DIR__ . '/../vendor/orchestra/testbench-core/laravel/streams';

    /**
     * @var string
     */
    protected $resourcesPath = __DIR__ . '/../vendor/orchestra/testbench-core/laravel/resources';

    /**
     * Setup the test environment. Scaffold some folders for the Streams application in a relative path to Orchestra.
     */
    protected function setUp(): void
    {
        if (!file_exists($this->streamsPath . '/data/widgets')) {
            mkdir($this->streamsPath . '/data/widgets', 0775, true);
        }

        if (!file_exists($this->streamsPath . '/widgets.json')) {
            file_put_contents($this->streamsPath . '/widgets.json', json_encode([
                "source" => [
                    "format" => "json"
                ],
                "slug" => "widgets",
                "fields" => [
                    "name" => "text",
                    "type" => "text"
                ]
            ]));
        }

        parent::setUp();
    }

    /**
     * Tear down.
     */
    protected function tearDown(): void
    {
        if (file_exists($this->streamsPath)) {
            File::deleteDirectory($this->streamsPath);
        }

        parent::tearDown();
    }

    /**
     * Add SPs.
     */
    protected function getPackageProviders($app)
    {
        return [\Streams\Core\StreamsServiceProvider::class];
    }

    /**
     * Don't handle the exception because we could pollute a test if we return any value.
     *
     * @param $object
     * @param $property
     * @return mixed
     * @throws ReflectionException
     *
     */
    protected function reflectObjectProperty($object, $property)
    {
        $reflectionClass = new \ReflectionClass($object);
        $reflectedProperty = $reflectionClass->getProperty($property);
        $reflectedProperty->setAccessible(true);
        return $reflectedProperty->getValue($object);
    }

    /**
     * Modify runtime environment
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
    }

    /**
     * Create a test entry.
     *
     * @param null $handle
     */
    protected function setUpTestEntry($handle = null)
    {
        $this->getTestingStream()->repository()->create([
            'id' => $handle ?? 'test',
            'name' => $handle ? ucfirst($handle) : 'Test',
            'type' => 'testing'
        ]);
    }

    /**
     * Tear down an entry.
     */
    protected function tearDownTestEntry()
    {
        $stream = $this->getTestingStream();

        if ($remove = $stream->repository()->find('test')) {
            $stream->repository()->delete($remove);
        }
    }

    /**
     * @return Stream
     */
    protected function getTestingStream()
    {
        return new Stream(json_decode(file_get_contents($this->streamsPath . '/widgets.json'), true));
    }
}
