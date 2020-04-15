<?php

if (!function_exists('loadAddonFactory')) {

    /**
     * Load an addon's factory.
     *
     * @param  string $path
     * @return string
     */
    function loadAddonFactory($vendorPath, $filePath = null)
    {
        app(\Illuminate\Database\Eloquent\Factory::class)
            ->load(base_path('vendor/' . $vendorPath . '/factories/' . ($filePath ?? '')));
    }
}
