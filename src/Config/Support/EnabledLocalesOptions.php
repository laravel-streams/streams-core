<?php namespace Anomaly\Streams\Platform\Config\Support;

use Anomaly\CheckboxesFieldType\CheckboxesFieldType;

/**
 * Class EnabledLocalesOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EnabledLocalesOptions
{

    /**
     * Handle the command.
     *
     * @param CheckboxesFieldType $fieldType
     */
    public function handle(CheckboxesFieldType $fieldType)
    {
        $fieldType->setOptions(
            array_combine(
                $keys = array_keys(config('streams::locales.supported')),
                array_map(
                    function ($locale) {
                        return trans('streams::locale.' . $locale . '.name') . ' (' . $locale . ')';
                    },
                    $keys
                )
            )
        );
    }
}
