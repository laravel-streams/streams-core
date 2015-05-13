<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Collection;

/**
 * Class FormCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormCollection extends Collection
{

    /**
     * Put a form into the form collection.
     *
     * @param             $slug
     * @param FormBuilder $form
     * @return $this
     */
    public function add($slug, FormBuilder $form)
    {
        $this->put($slug, $form);

        return $this;
    }
}
