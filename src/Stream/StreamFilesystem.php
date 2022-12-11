<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Contracts\Filesystem\Filesystem;

class StreamFilesystem implements Filesystem
{
    public Filesystem $storage;

    public function __construct(public Stream $stream, public string $disk)
    {
        $this->storage = Storage::disk($disk);
    }

    public function scan(string $path = null): void
    {
        foreach ($this->storage->allDirectories($path) as $directory) {
            dd($directory);
            $this->indexDirectory($directory);
        }

        foreach ($this->storage->allFiles($path) as $file) {
            $this->indexFile($file);
        }
    }

    public function indexDirectory(string $directory)
    {
        $entry = $this->stream
            ->entries()
            ->where('disk', $this->disk)
            ->where('path', $directory)
            ->first();

        if (!$entry) {
            $this->stream
                ->entries()
                ->create([
                    'disk' => $this->disk,
                    'is_dir' => true,
                    'path' => $directory,
                    'name' => basename($directory),
                    'visibility' => $this->storage->getVisibility($directory),
                    'last_modified' => $this->storage->lastModified($directory),
                ]);
        } else {
            $entry->loadPrototypeAttributes([
                'is_dir' => true,
                'name' => basename($directory),
                'visibility' => $this->storage->getVisibility($directory),
                'last_modified' => $this->storage->lastModified($directory),
            ]);

            $entry->save();
        }
    }

    public function indexFile(string $file)
    {
        $entry = $this->stream
            ->entries()
            ->where('disk', $this->disk)
            ->where('path', $file)
            ->first();

        if (!$entry) {
            $this->stream
                ->entries()
                ->create([
                    'path' => $file,
                    'is_dir' => false,
                    'disk' => $this->disk,
                    'name' => basename($file),
                    'size' => $this->storage->size($file),
                    'mime_type' => $this->storage->mimeType($file),
                    'visibility' => $this->storage->getVisibility($file),
                    'last_modified' => $this->storage->lastModified($file),
                    'extension' => pathinfo($file, PATHINFO_EXTENSION),
                ]);
        } else {
            $entry->fill([
                'path' => $file,
                'is_dir' => false,
                'disk' => $this->disk,
                'name' => basename($file),
                'size' => $this->storage->size($file),
                'mime_type' => $this->storage->mimeType($file),
                'visibility' => $this->storage->getVisibility($file),
                'last_modified' => $this->storage->lastModified($file),
                'extension' => pathinfo($file, PATHINFO_EXTENSION),
            ]);

            $entry->save();
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

    public function getVisibility($path): string
    {
        return $this->storage->getVisibility($path);
    }

    public function setVisibility($path, $visibility): bool
    {
        return $this->storage->setVisibility($path, $visibility);
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

    public function delete($paths): bool
    {
        dd('Implement StreamDisk::delete');
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

    public function size($path): int
    {
        return $this->stream
            ->entries()
            ->where('disk', $this->disk)
            ->where('path', $path)
            ->first()
            ?->size;
    }

    public function lastModified($path): int
    {
        return $this->stream
            ->entries()
            ->where('disk', $this->disk)
            ->where('path', $path)
            ->first()
            ?->last_modified;
    }

    public function files($directory = null, $recursive = false): array
    {
        dd('Implement StreamDisk::files');
    }

    public function allFiles($directory = null): array
    {
        dd('Implement StreamDisk::allFiles');
    }

    public function directories($directory = null, $recursive = false): array
    {
        dd('Implement StreamDisk::directories');
    }

    public function allDirectories($directory = null): array
    {
        dd('Implement StreamDisk::allDirectories');
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
        dd('Implement StreamDisk::deleteDirectory');
    }


    protected function extractDisk(string $path = null): array
    {
        $parts = explode('://', $path);

        $path = array_pop($parts);

        $disk = config('filesystems.default');

        if ($parts) {
            $disk = array_pop($parts);
        }

        return [$disk, $path];
    }
}
