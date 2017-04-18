<?php namespace Anomaly\Streams\Platform\Field\Form\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Translation\Translator;

/**
 * Class GetConfigFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetConfigFields
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * The field type object.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new GetConfigFields instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FormBuilder $builder, FieldType $fieldType)
    {
        $this->builder   = $builder;
        $this->fieldType = $fieldType;
    }

    /**
     * Handle the command.
     *
     * @param Repository $config
     * @param Evaluator  $evaluator
     */
    public function handle(Repository $config, Evaluator $evaluator, Translator $translator)
    {
        if (!$fields = $config->get($this->fieldType->getNamespace('config/config'))) {
            $fields = $config->get($this->fieldType->getNamespace('config'), []);
        }

        $fields = $evaluator->evaluate($fields);

        foreach ($fields as $slug => $field) {

            /*
             * Determine the field label.
             */
            $label = $this->fieldType->getNamespace('config.' . $slug . '.label');

            if (!$translator->has($label)) {
                $label = $this->fieldType->getNamespace('config.' . $slug . '.name');
            }

            $field['label'] = array_get($field, 'label', $label);

            /*
             * Determine the instructions.
             */
            $instructions = $this->fieldType->getNamespace('config.' . $slug . '.instructions');

            if ($translator->has($instructions)) {
                $field['instructions'] = $instructions;
            }

            /*
             * Determine the placeholder.
             */
            $placeholder = $this->fieldType->getNamespace('config.' . $slug . '.placeholder');

            if ($translator->has($placeholder)) {
                $field['placeholder'] = $placeholder;
            }

            /*
             * Determine the warning.
             */
            $warning = $this->fieldType->getNamespace('config.' . $slug . '.warning');

            if ($translator->has($warning)) {
                $field['warning'] = $warning;
            }

            /*
             * Set the configuration value.
             */
            $field['value'] = array_get($this->fieldType->getConfig(), $slug);

            // Prefix the slugs.
            $field['field'] = 'config__' . $slug;

            $fields['config__' . $slug] = $field;

            $this->builder->addField($field);
        }
    }
}
