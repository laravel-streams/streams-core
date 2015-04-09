<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldAssignmentFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldAssignmentFormBuilder extends FormBuilder
{

    /**
     * The form model.
     *
     * @var string
     */
    protected $model = 'Anomaly\Streams\Platform\Field\FieldModel';

    /**
     * The form fields.
     *
     * @var string
     */
    protected $fields = 'Anomaly\Streams\Platform\Field\Form\FieldAssignmentFormFields@handle';

    /**
     * Create a new FieldAssignmentFormBuilder instance.
     *
     * @param Form  $form
     * @param Asset $asset
     */
    public function __construct(Form $form, Asset $asset)
    {
        $asset->add('scripts.js', 'streams::js/form/field_assignment.js', ['debug']);

        parent::__construct($form);
    }
}
