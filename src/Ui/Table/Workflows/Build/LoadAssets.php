<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Asset\Facades\Assets;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Support\Breadcrumb;

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
     * @param TableBuilder $builder
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(TableBuilder $builder, Breadcrumb $breadcrumbs)
    {

        Assets::collection('scripts.js', 'public::vendor/anomaly/core/js/table/table.js');

        foreach ($builder->assets as $collection => $assets) {
            Assets::collection($collection)->merge($assets);
        }
    }
}
