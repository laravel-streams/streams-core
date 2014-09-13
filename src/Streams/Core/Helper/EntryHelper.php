<?php namespace Streams\Core\Helper;

use Streams\Core\Model\EntryModel;

class EntryHelper
{
    /**
     * Get an entry model class from slug / namespace.
     *
     * @param $stream_slug
     * @param $stream_namespace
     * @return mixed
     */
    public function getModelClass($slug, $namespace)
    {
        if ($slug instanceof EntryModel) {
            return $slug;
        } elseif (is_string($slug) and class_exists($slug)) {
            return new $slug;
        } elseif ($slug and $namespace) {
            return studly_case("Streams\Model\\_{$namespace}\\_{$namespace}_{$slug}_EntryModel");
        }

        return null;
    }
}
