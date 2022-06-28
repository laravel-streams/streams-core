<?php

namespace Streams\Core\Filesystem;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Streams\Core\Support\Facades\Streams;

class Filesystem
{
    public function index(string $path = null)
    {
        list($disk, $path) = $this->extractDisk($path);

        $storage = Storage::disk($disk);

        foreach ($storage->allDirectories($path) as $directory) {

            $entry = Streams::entries('core.filesystem')
                ->where('disk', $disk)
                ->where('path', $path . '/' . $directory)
                ->first();

            if (!$entry) {
                Streams::entries('core.filesystem')->create([
                    'disk' => $disk,
                    'is_dir' => true,
                    'name' => $directory,
                    'path' => $path . '/' . $directory,
                    'visibility' => $storage->getVisibility($path . '/' . $directory),
                    'last_modified' => $storage->lastModified($path . '/' . $directory),
                ]);
            }
        }

        foreach ($storage->allFiles($path) as $file) {

            $entry = Streams::entries('core.filesystem')
                ->where('disk', $disk)
                ->where('path', $path . '/' . $file)
                ->first();

            if (!$entry) {
                Streams::entries('core.filesystem')->create([
                    'disk' => $disk,
                    'is_dir' => false,
                    'name' => basename($file),
                    'path' => $path . '/' . $file,
                    'size' => $storage->size($path . '/' . $file),
                    //'mime_type' => $storage->mimeType(),
                    'visibility' => $storage->getVisibility($path . '/' . $file),
                    'last_modified' => $storage->lastModified($path . '/' . $file),
                    'extension' => pathinfo($file, PATHINFO_EXTENSION),
                ]);
            }
        }
    }

    public function exists(string $path): bool
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->exists($path);
    }

    public function get(string $path): string|null
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->get($path);
    }

    /**
     * @return resource|null The path resource or null on failure.
     */
    public function readStream(string $path)
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->readStream($path);
    }

    public function put(string $path, string $contents, array $options = []): bool
    {
        list($disk, $path) = $this->extractDisk($path);

        if ($result = Storage::disk($disk)->put($path, $contents, $options)) {

            Streams::entries('core.filesystem')->create([
                'disk' => $disk,
                'path' => $path,
                'is_dir' => false,
                'size' => Storage::disk($disk)->size($path),
                'extension' => pathinfo($path, PATHINFO_EXTENSION),
                'mime_type' => Storage::disk($disk)->mimeType($path),
                'visibility' => Storage::disk($disk)->getVisibility($path),
                'last_modified' => Storage::disk($disk)->lastModified($path),
            ]);
        }

        return $result;
    }

    public function writeStream($path, $resource, array $options = [])
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->writeStream($path, $resource, $options);
    }

    public function getVisibility(string $path): string
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->getVisibility($path);
    }

    public function setVisibility(string $path, string $visibility): bool
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->setVisibility($path, $visibility);
    }

    public function prepend(string $path, string $data): bool
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->prepend($path, $data);
    }

    public function append(string $path, string $data): bool
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->append($path, $data);
    }

    public function delete(string|array $paths): bool
    {
        $success = true;

        $paths = (array) $paths;

        foreach ($paths as $path) {

            list($disk, $path) = $this->extractDisk($path);

            $result = Storage::disk($disk)->delete($paths);

            if (!$result) {
                $success = false;
            }

            if ($result) {
                // Clean up
            }
        }

        return $success;
    }

    public function copy(string $from, string $to): bool
    {
        list($disk, $from) = $this->extractDisk($from);
        list($toDisk, $to) = $this->extractDisk($to);

        if ($disk !== $toDisk) {
            throw new \Exception("The destination disk [{$toDisk}] must be the same as the origin disk [{$disk}].");
        }

        if ($result = Storage::disk($disk)->copy($from, $to)) {

            $entry = Streams::entries('core.filesystem')
                ->where('disk', $disk)
                ->where('path', $from)
                ->first();

            if (!$entry) {
                return $result;
            }

            $data = $entry->toArray();

            Arr::pull($data, 'id');

            $data['path'] = $to;

            Streams::entries('core.filesystem')->create($data);
        }

        return $result;
    }

    public function move(string $from, string $to): bool
    {
        list($disk, $from) = $this->extractDisk($from);
        list($toDisk, $to) = $this->extractDisk($to);

        if ($disk !== $toDisk) {
            throw new \Exception("The destination disk [{$toDisk}] must be the same as the origin disk [{$disk}].");
        }

        if ($result = Storage::disk($disk)->move($from, $to)) {

            $entry = Streams::entries('core.filesystem')
                ->where('disk', $disk)
                ->where('path', $from)
                ->first();

            $entry->path = $to;

            $entry->save();
        }

        return $result;
    }

    public function size(string $path): int
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->size($path);
    }

    public function lastModified(string $path): int
    {
        list($disk, $path) = $this->extractDisk($path);

        return Storage::disk($disk)->lastModified($path);
    }

    public function files(string|null $directory = null, bool $recursive = false): array
    {
        list($disk, $directory) = $this->extractDisk($directory);

        return Storage::disk($disk)->files($directory, $recursive);
    }

    public function allFiles(string|null $directory = null): array
    {
        list($disk, $directory) = $this->extractDisk($directory);

        return Storage::disk($disk)->allFiles($directory);
    }

    public function directories(string|null $directory = null, bool $recursive = false): array
    {
        list($disk, $directory) = $this->extractDisk($directory);

        return Storage::disk($disk)->directories($directory);
    }

    public function allDirectories(string $directory = null): array
    {
        list($disk, $directory) = $this->extractDisk($directory);

        return Storage::disk($disk)->allDirectories($directory);
    }

    public function makeDirectory(string $path): bool
    {
        list($disk, $path) = $this->extractDisk($path);

        if ($result = Storage::disk($disk)->makeDirectory($path)) {
            Streams::entries('core.filesystem')->create([
                'disk' => $disk,
                'path' => $path,
                'is_dir' => true,
                'visibility' => Storage::disk($disk)->getVisibility($path),
                'last_modified' => Storage::disk($disk)->lastModified($path),
            ]);
        }

        return $result;
    }

    public function deleteDirectory(string $directory): bool
    {
        list($disk, $directory) = $this->extractDisk($directory);

        if ($result = Storage::disk($disk)->deleteDirectory($directory)) {
            Streams::entries('core.filesystem')
                ->where('disk', $disk)
                ->where('path', 'LIKE', $directory . '%')
                ->delete();
        }

        File::deleteDirectory('streams/data/files');

        File::moveDirectory('streams/data/fore.filesystem', 'streams/data/files');

        File::deleteDirectory('streams/data/fore.filesystem');

        return $result;
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
