<?php namespace Anomaly\Streams\Platform\Asset;

/**
 * Class AssetTransformer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssetTransformer
{

    /**
     * Transform the filters.
     *
     * @param array $filters
     * @return array
     */
    public static function transform(array $filters)
    {
        foreach ($filters as $k => &$filter) {

            /**
             * Transform filters.
             */
            if ($class = config('streams::assets.filters.' . $filter, [])) {
                $filter = new $class;
            }
        }

        return $filters;
    }
}
