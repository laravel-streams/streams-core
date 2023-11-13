<?php

namespace Anomaly\Streams\Platform\Addon\Command;

class GetNamespaceWithComposer
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle()
    {
        $path = $this->path;

        if (!file_exists($path . '/composer.json')) {
            return null;
        }

        if (!$composer = json_decode(file_get_contents($path . '/composer.json'), true)) {
            return null;
        }

        foreach (array_get($composer['autoload'], 'psr-4', []) as $namespace => $autoload) {
            break;
        }

        $vendor = strtolower(array_first(explode('\\', $namespace)));
        $slug   = strtolower(substr(basename($path), 0, strpos(basename($path), '-')));
        $type   = strtolower(substr(basename($path), strpos(basename($path), '-') + 1));

        return "{$vendor}.{$type}.{$slug}";
    }
}
