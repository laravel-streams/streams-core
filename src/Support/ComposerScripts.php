<?php

namespace Streams\Core\Support;

use Composer\Installer\InstallerEvent;
use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class ComposerScripts
{
    protected static $type = 'streams-addon';

    protected static $outputPath = __DIR__ . '/../../resources/generated.json';

    public static function update(Event|PackageEvent|InstallerEvent $event)
    {
        static::handle($event);
    }

    /**
     * @return array{basePath: string, vendorDir: string, binDir: string, vendorPath: string, binPath: string, addons: array}
     * @throws \JsonException
     */
    public static function getGenerated()
    {
        if (!file_exists(static::$outputPath)) {
            return [];
        }
        
        return json_decode(file_get_contents(static::$outputPath), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param \Composer\Script\Event|\Composer\Installer\PackageEvent $event
     * @return void
     * @throws \JsonException
     */
    protected static function handle(Event|PackageEvent|InstallerEvent $event)
    {
        $basePath = getcwd(); // composer is always executed in project root

        // lets load up
        $binPath    = $event->getComposer()->getConfig()->get('bin-dir');
        $vendorPath = $event->getComposer()->getConfig()->get('vendor-dir');
        $binDir     = basename($binPath);
        $vendorDir  = basename($vendorPath);
        require_once $vendorPath . '/autoload.php';

        $locker = $event->getComposer()->getLocker();
        if ($locker === null) {
            $event->getIO()->warning('Laravel Streams could not generate the addon list.');
            return;
        }
        $locked = $locker->isLocked();
        $fresh  = $locker->isFresh();
        $data   = $locker->getLockData();
        $addons = collect($data[ 'packages' ])
            ->merge($data[ 'packages-dev' ])
            ->mapWithKeys(fn($p) => [ $p[ 'name' ] => $p ])
            ->where('type', static::$type)
            ->map(function ($package) use ($basePath, $vendorPath) {
                $name             = $package[ 'name' ];
                $path             = $vendorPath . DIRECTORY_SEPARATOR . $name;
                $composerPath     = $path . DIRECTORY_SEPARATOR . 'composer.json';
                $fullPath         = $basePath . DIRECTORY_SEPARATOR . $name;
                $fullComposerPath = $fullPath . DIRECTORY_SEPARATOR . 'composer.json';
                return [
                    'name'     => $name,
                    'paths'    => compact('path', 'composerPath', 'fullPath', 'fullComposerPath'),
                    'composer' => $package,

                ];
            })
            ->toArray();
        $data   = compact('basePath', 'addons', 'vendorDir', 'binDir', 'vendorPath', 'binPath');
        file_put_contents(static::$outputPath, json_encode($data, JSON_THROW_ON_ERROR));
    }

}
