<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Support\Breadcrumb;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Asset\Facades\Assets;

/**
 * Class LoadAssets
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadAssets
{

    /**
     * Handle the command.
     *
     * @param TreeBuilder $builder
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(TreeBuilder $builder, Breadcrumb $breadcrumbs)
    {

        //Assets::collection('scripts.js', 'public::vendor/anomaly/core/js/tree/tree.js');

        foreach ($builder->assets as $collection => $assets) {
            Assets::collection($collection)->merge($assets);
        }
    }
}
