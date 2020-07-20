<?php

use Anomaly\Streams\Platform\Stream\Stream;
use Illuminate\Support\Facades\File;

/**
 * Class StreamsTestCase
 */
class StreamsTestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var string
     */
    protected $streamsPath = __DIR__ . '/../vendor/orchestra/testbench-core/laravel/streams';

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
                    "name" => "text"
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
        return [\Anomaly\Streams\Platform\StreamsServiceProvider::class];
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
     */
    protected function setUpTestEntry()
    {
        $this->getTestingStream()->repository()->create([
            'id' => 'test',
            'name' => 'Test',
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
