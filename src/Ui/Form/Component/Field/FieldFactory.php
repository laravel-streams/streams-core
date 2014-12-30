<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\Contract\FieldInterface;

/**
 * Class FieldFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldFactory
{

    /**
     * The default field.
     *
     * @var string
     */
    protected $field = 'Anomaly\Streams\Platform\Ui\Form\Component\Field\Field';

    /**
     * Make an field.
     *
     * @param  array $parameters
     * @return FieldInterface
     */
    public function make(array $parameters)
    {
        $field = app()->make(array_get($parameters, 'field', $this->field), $parameters);

        $this->hydrate($field, $parameters);

        return $field;
    }

    /**
     * Hydrate the field with it's remaining parameters.
     *
     * @param FieldInterface $field
     * @param array          $parameters
     */
    protected function hydrate(FieldInterface $field, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($field, $method)) {
                $field->{$method}($value);
            }
        }
    }
}
