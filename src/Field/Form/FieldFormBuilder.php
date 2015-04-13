<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormBuilder extends FormBuilder
{

    /**
     * Fire when ready.
     *
     * @param Asset $asset
     * @throws \Exception
     */
    public function onReady(Asset $asset)
    {
        $asset->add('scripts.js', 'streams::js/form/field_type.js');
    }
}
