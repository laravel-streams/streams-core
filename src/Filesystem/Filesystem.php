<?php

namespace Streams\Core\Filesystem;

use Illuminate\Support\Facades\Storage;

class Filesystem
{
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

        return Storage::disk($disk)->put($path, $contents, $options);
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
        list($disk, $to) = $this->extractDisk($to);

        return Storage::disk($disk)->copy($from, $to);
    }

    public function move(string $from, string $to): bool
    {
        list($disk, $from) = $this->extractDisk($from);
        list($disk, $to) = $this->extractDisk($to);

        return Storage::disk($disk)->move($from, $to);
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

        return Storage::disk($disk)->makeDirectory($path);
    }

    public function deleteDirectory(string $directory): bool
    {
        list($disk, $directory) = $this->extractDisk($directory);

        return Storage::disk($disk)->deleteDirectory($directory);
    }

    public function extractDisk(string $path): array
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
