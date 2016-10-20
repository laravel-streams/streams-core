<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Collection;

/**
 * Class FormCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormCollection extends Collection
{

    /**
     * Put a form into the form collection.
     *
     * @param              $slug
     * @param  FormBuilder $form
     * @return $this
     */
    public function add($slug, FormBuilder $form)
    {
        $this->put($slug, $form);

        return $this;
    }
}
