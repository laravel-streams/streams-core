<?php namespace Anomaly\Streams\Platform\Field\Form\Validator;

use Illuminate\Contracts\Config\Repository;

/**
 * Class SlugValidator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SlugValidator
{

    /**
     * Handle the validation.
     *
     * @param Repository $config
     * @param            $value
     */
    public function handle(Repository $config, $value)
    {
        return !in_array($value, array_keys($config->get('streams::locales.supported')));
    }
}
