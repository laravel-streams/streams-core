<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

/**
 * Class FormFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormFactory
{

    /**
     * Make the form.
     *
     * @param  null         $builder
     * @param  array        $parameters
     * @return FormCriteria
     */
    public function make(array $parameters = [])
    {
        $parameters = $this->resolve($parameters);

        $builder = App::make($parameters['builder']);

        $criteria = substr(get_class($builder), 0, -7) . 'Criteria';

        if (!class_exists($criteria)) {
            $criteria = 'Anomaly\Streams\Platform\Ui\Form\FormCriteria';
        }

        return App::make(
            $criteria,
            [
                'builder'    => $builder,
                'parameters' => $parameters,
            ]
        );
    }

    /**
     * @param  array $parameters
     * @return array
     */
    protected function resolve(array $parameters)
    {

        /*
         * Set the default builder and model based
         * a stream and namespace parameter provided.
         */
        if (!$builder = array_get($parameters, 'builder')) {
            if (!$model = array_get($parameters, 'model')) {
                $stream    = ucfirst(camel_case(array_get($parameters, 'stream')));
                $namespace = ucfirst(camel_case(array_get($parameters, 'namespace')));

                $model = 'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel';

                array_set($parameters, 'model', $model);
            }

            array_set($parameters, 'builder', 'Anomaly\Streams\Platform\Ui\Form\FormBuilder');
        }

        return $parameters;
    }
}
