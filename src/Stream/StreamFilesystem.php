<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * This class is a wrapper for the Laravel
 * filesystem. It is used to index data
 * but otherwise passes through to the
 * underlying filesystem.
 */
class StreamFilesystem implements Filesystem
{
    public Filesystem $storage;

    public function __construct(public Stream $stream, public string $disk)
    {
        $this->storage = Storage::disk($disk);
    }

    public function index(string $path = null): void
    {
        foreach ($this->storage->allDirectories($path) as $directory) {
            $this->indexDirectory($directory);
        }

        foreach ($this->storage->allFiles($path) as $file) {
            $this->indexFile($file);
        }
    }

    public function exists($path): bool
    {
        return $this->storage->exists($path);
    }

    public function get($path): string|null
    {
        return $this->storage->get($path);
    }

    public function readStream($path)
    {
        return $this->storage->readStream($path);
    }

    public function put($path, $contents, $options = []): bool
    {
        if ($result = $this->storage->put($path, $contents, $options)) {
            $this->indexFile($path);
        }

        return $result;
    }

    public function writeStream($path, $resource, array $options = []): bool
    {
        if ($result = $this->storage->writeStream($path, $resource, $options)) {
            $this->indexFile($path);
        }

        return $result;
    }

    public function prepend($path, $data): bool
    {
        if ($result = $this->storage->prepend($path, $data)) {
            $this->indexFile($path);
        }

        return $result;
    }

    public function append($path, $data): bool
    {
        if ($result = $this->storage->append($path, $data)) {
            $this->indexFile($path);
        }

        return $result;
    }

    public function copy($from, $to): bool
    {
        if ($result = $this->storage->copy($from, $to)) {
            $this->indexFile($to);
        }

        return $result;
    }

    public function move($from, $to): bool
    {
        if ($result = $this->storage->move($from, $to)) {

            $entry = $this->stream
                ->entries()
                ->where('disk', $this->disk)
                ->where('path', $from)
                ->first();

            $entry->path = $to;

            $entry->save();
        }

        return $result;
    }

    public function delete($paths): bool
    {
        $result = true;

        foreach ((array) $paths as $path) {

            if ($this->storage->delete($path)) {
                $this->stream
                    ->entries()
                    ->where('disk', $this->disk)
                    ->where('path', $path)
                    ->delete();
            } else {
                $result = false;
            }
        }

        return $result;
    }

    public function getVisibility($path): string
    {
        // @todo sync the value
        return $this->storage->getVisibility($path);
    }

    public function setVisibility($path, $visibility): bool
    {
        // @todo sync the value
        return $this->storage->setVisibility($path, $visibility);
    }

    public function size($path): int
    {
        // @todo sync the value
        return $this->storage->size($path);
    }

    public function lastModified($path): int
    {
        // @todo sync the value
        return $this->storage->lastModified($path);
    }

    public function files($directory = null, $recursive = false): array
    {
        return $this->storage->files($directory, $recursive);
    }

    public function allFiles($directory = null): array
    {
        return $this->storage->allFiles($directory);
    }

    public function directories($directory = null, $recursive = false): array
    {
        return $this->storage->directories($directory, $recursive);
    }

    public function allDirectories($directory = null): array
    {
        return $this->storage->allDirectories($directory);
    }

    public function makeDirectory($path): bool
    {
        if ($result = $this->storage->makeDirectory($path)) {
            $this->indexDirectory($path);
        }

        return $result;
    }

    public function deleteDirectory($directory): bool
    {
        if ($result = $this->storage->delete($directory)) {
            $this->stream
                ->entries()
                ->where('disk', $this->disk)
                ->where('path', $directory)
                ->delete();
        }

        return $result;
    }
}
