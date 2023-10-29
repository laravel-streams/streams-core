<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Stream\StreamFilesystem;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Filesystem\FilesystemAdapter;

class StreamFilesystemTest extends CoreTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Streams::register([
            'id' => 'files',
            'fields' => [
                [
                    'handle' => 'id',
                    'type' => 'uuid',
                    'required' => true,
                    'unique' => true,
                    'config' => [
                        'default' => true
                    ]
                ],
                [
                    'handle' => 'path',
                    'type' => 'string',
                    'required' => true
                ],
                [
                    'handle' => 'is_dir',
                    'type' => 'boolean',
                    'required' => true
                ],
                [
                    'handle' => 'disk',
                    'type' => 'string',
                    'required' => true
                ],
                [
                    'handle' => 'name',
                    'type' => 'string',
                    'required' => true
                ],
                [
                    'handle' => 'size',
                    'type' => 'integer'
                ],
                [
                    'handle' => 'mime_type',
                    'type' => 'string'
                ],
                [
                    'handle' => 'visibility',
                    'type' => 'string'
                ],
                [
                    'handle' => 'last_modified',
                    'type' => 'datetime'
                ],
                [
                    'handle' => 'extension',
                    'type' => 'string'
                ]
            ]
        ]);

        Config::set('filesystems.disks.local.stream', 'files');
    }

    function tearDown(): void
    {
        Storage::disk('local')->delete([
            'img/example2.jpg',
            'img/example3.jpg',
            'img/example4.jpg',
            'img/example5.jpg',
            'img/test/example.jpg',
            'img/test',
        ]);

        parent::tearDown();
    }

    public function test_it_returns_filesystems()
    {
        $this->assertInstanceOf(
            StreamFilesystem::class,
            Streams::filesystem('local')
        );

        $this->assertInstanceOf(
            FilesystemAdapter::class,
            Streams::filesystem('local')->storage
        );
    }

    public function test_it_indexes_filesystem_content()
    {
        $this->assertEquals(0, Streams::repository('files')->count());

        Streams::filesystem('local')->index();

        $this->assertEquals(7, Streams::repository('files')->count());
    }

    public function test_it_can_read_from_filesystem()
    {
        $filesystem = Streams::filesystem('local');

        $filesystem->index();

        $this->assertTrue($filesystem->exists('img/example.jpg'));
        $this->assertIsString($filesystem->get('img/example.jpg'));
        $this->assertIsResource($filesystem->readStream('img/example.jpg'));

        $this->assertSame(1, count($filesystem->files()));
        $this->assertSame(4, count($filesystem->allFiles()));

        $this->assertSame(2, count($filesystem->directories()));
        $this->assertSame(3, count($filesystem->allDirectories()));

        $this->assertIsInt($filesystem->size('img/example.jpg'));
        $this->assertIsInt($filesystem->lastModified('img/example.jpg'));
        $this->assertTrue($filesystem->setVisibility('img/example.jpg', 'public'));
        $this->assertSame('public', $filesystem->getVisibility('img/example.jpg'));
    }

    public function test_it_can_write_to_filesystem()
    {
        $filesystem = Streams::filesystem('local');

        $repository = $filesystem->stream->repository();

        $filesystem->index();

        $image = Images::make('storage/app/img/example.jpg');

        $result = $filesystem->put('img/example2.jpg', $image->fit(100, 100)->data());

        $this->assertTrue($result);
        $this->assertNotNull($repository->findBy('path', 'img/example2.jpg'));

        $result = $filesystem->writeStream('img/example3.jpg', fopen(base_path('storage/app/img/example.jpg'), 'r'));

        $this->assertTrue($result);
        $this->assertNotNull($repository->findBy('path', 'img/example3.jpg'));

        $result = $filesystem->prepend('img/example3.jpg', $image->data());

        $this->assertTrue($result);
        $this->assertTrue(($original = $filesystem->size('img/example3.jpg')) > $filesystem->size('img/example.jpg'));

        $result = $filesystem->append('img/example3.jpg', $image->data());

        $this->assertTrue($result);
        $this->assertTrue($filesystem->size('img/example3.jpg') > $original);

        $result = $filesystem->copy('img/example3.jpg', 'img/example4.jpg');

        $this->assertTrue($result);
        $this->assertNotNull($repository->findBy('path', 'img/example4.jpg'));

        $result = $filesystem->move('img/example4.jpg', 'img/example5.jpg');

        $this->assertTrue($result);
        $this->assertNull($repository->findBy('path', 'img/example4.jpg'));
        $this->assertNotNull($repository->findBy('path', 'img/example5.jpg'));
    }

    public function test_it_tracks_deletions()
    {
        $filesystem = Streams::filesystem('local');

        $repository = $filesystem->stream->repository();

        $filesystem->index();

        $filesystem->copy('img/example.jpg', 'img/example2.jpg');

        $this->assertNotNull($repository->findBy('path', 'img/example2.jpg'));

        $filesystem->delete('img/example2.jpg');

        $this->assertNull($repository->findBy('path', 'img/example2.jpg'));

        $filesystem->makeDirectory('img/test');

        $this->assertNotNull($repository->findBy('path', 'img/test'));

        $filesystem->copy('img/example.jpg', 'img/test/example.jpg');

        $filesystem->deleteDirectory('img/test', true);

        $this->assertNull($repository->findBy('path', 'img/test'));
    }
}
