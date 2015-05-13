<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Field\Form\Command\AutoAssignField;
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
     * The related stream namespace.
     *
     * @var null|string
     */
    protected $namespace = null;

    /**
     * The field type to use.
     *
     * @var null|string
     */
    protected $fieldType = null;

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
    protected $fields = 'Anomaly\Streams\Platform\Field\Form\FieldFormFields@handle';

    /**
     * The form buttons.
     *
     * @var array
     */
    protected $actions = [
        'save'              => [
            'enabled' => 'edit'
        ],
        'save_and_continue' => [
            'enabled' => 'create'
        ]
    ];

    /**
     * Fire just before saving the entry.
     */
    public function onSaving()
    {
        $entry = $this->getFormEntry();

        if (!$entry->namespace) {
            $entry->namespace = $this->getNamespace();
        }

        if (!$entry->type) {
            $entry->type = $this->getFieldType();
        }
    }

    /**
     * Fire after the field is saved.
     */
    public function onSaved()
    {
        $this->dispatch(new AutoAssignField($this));
    }

    /**
     * Get the namespace.
     *
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the namespace.
     *
     * @param $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get the field type.
     *
     * @return null|string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Set the field type.
     *
     * @param $fieldType
     * @return $this
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;

        return $this;
    }
}
