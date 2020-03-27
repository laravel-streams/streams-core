<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Asset\AssetManager;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class AddAssets
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddAssets
{

    /**
     * Handle the command.
     *
     * @param  AssetManager $asset
     * @param  FormBuilder $builder
     * @throws \Exception
     */
    public function handle(AssetManager $asset, FormBuilder $builder)
    {
        foreach ($builder->getAssets() as $collection => $assets) {

            if (!is_array($assets)) {
                $assets = [$assets];
            }

            foreach ($assets as $file) {

                $filters = explode('|', $file);

                $file = array_shift($filters);

                $asset->add($collection, $file, $filters);
            }
        }
    }
}
