<?php namespace Anomaly\Streams\Platform\Field\Form\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Support\Evaluator;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetConfigFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form\Command
 */
class GetConfigFields implements SelfHandling
{

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
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Handle the command.
     *
     * @param Repository $config
     * @param Evaluator  $evaluator
     */
    public function handle(Repository $config, Evaluator $evaluator)
    {
        $fields = [];

        $config = $evaluator->evaluate($config->get($this->fieldType->getNamespace('config'), []));

        foreach ($config as $slug => $field) {

            /**
             * Determine the field label.
             */
            $label = $this->fieldType->getNamespace('config.' . $slug . '.label');

            if (!trans()->has($label)) {
                $label = trans($this->fieldType->getNamespace('config.' . $slug . '.name'));
            }

            $field['label'] = array_get($field, 'label', $label);

            /**
             * Determine the instructions.
             */
            $instructions = $this->fieldType->getNamespace('config.' . $slug . '.instructions');

            if (trans()->has($instructions)) {
                $field['instructions'] = $instructions;
            }

            /**
             * Determine the placeholder.
             */
            $placeholder = $this->fieldType->getNamespace('config.' . $slug . '.placeholder');

            if (trans()->has($placeholder)) {
                $field['placeholder'] = $placeholder;
            }

            // Prefix the slugs.
            $field['slug'] = 'config_' . $slug;

            $fields['config_' . $slug] = $field;
        }

        return $fields;
    }
}
