<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Anomaly\Streams\Platform\Support\Breadcrumb;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
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
     * @param GridBuilder $builder
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(GridBuilder $builder, Breadcrumb $breadcrumbs)
    {

        //Assets::collection('scripts.js', 'public::vendor/anomaly/core/js/grid/grid.js');

        foreach ($builder->assets as $collection => $assets) {
            Assets::collection($collection)->merge($assets);
        }
    }
}
