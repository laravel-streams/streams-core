<?php

function loadAddonFactory($vendorPath, $filePath = null)
{
    app(\Illuminate\Database\Eloquent\Factory::class)->load(base_path('vendor/'.$vendorPath.'/factories/'.($filePath ?? '')));
}