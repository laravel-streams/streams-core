<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Anomaly\Streams\Platform\Repository\Repository;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Traits\Prototype;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

/**
 * Class Stream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Stream implements Arrayable, Jsonable
{

    use Macroable;
    use HasMemory;
    use Prototype;
    use ForwardsCalls;
    use FiresCallbacks;

    /**
     * Return the entry repository.
     * 
     * @todo Let's review this idea. Could use for allowing configuration of criteria too. Flat or in some kinda config array?
     * @return RepositoryInterface
     */
    public function repository()
    {
        $repository = $this->repository ?: Repository::class;

        return new $repository($this);
    }

    /**
     * Return the entry criteria.
     * 
     * @return CriteriaInterface
     */
    public function entries()
    {
        return $this
            ->repository()
            ->newCriteria();
    }

    /**
     * Return an entry validator with the data.
     * 
     * @param $data
     * @return Validator
     */
    public function validator($data): Validator
    {
        $data = Arr::make($data);

        $factory = App::make(Factory::class);

        /**
         * https://gph.is/g/Eqn635a
         */
        $rules = $this->getPrototypeAttribute('rules') ?: [];
        $validators = $this->getPrototypeAttribute('validators') ?: [];
        
        $fieldRules = $this->fields->rules();
        $fieldValidators = $this->fields->validators();

        /**
         * Merge stream and field configurations.
         */
        foreach ($fieldRules as $field => $rules) {
            if ($rules) {
                $fieldRules[$field] = array_merge(Arr::get($fieldRules, $field, []), $rules);
            }
        }

        foreach ($fieldValidators as $field => $validators) {
            if ($validators) {
                $fieldValidators[$field] = array_merge(Arr::get($fieldValidators, $field, []), $validators);
            }
        }

        /**
         * Process validator rules.
         */
        $rules = array_map(function ($rules) {
            return implode('|', array_unique($rules));
        }, $rules);

        $fieldRules = array_map(function ($rules) {
            return implode('|', array_unique($rules));
        }, $fieldRules);

        /**
         * Extend the factory with custom validators.
         */
        foreach ($validators as $rule => $validator) {

            $handler = Arr::get($validator, 'handler');

            if (strpos($handler, '@')) {
                $handler = function ($attribute, $value, $parameters, Validator $validator) use ($handler) {

                    App::call(
                        $handler,
                        [
                            'value' => $value,
                            'attribute' => $attribute,
                            'validator' => $validator,
                            'parameters' => $parameters,
                        ],
                        'handle'
                    );
                };
            }

            $factory->extend(
                $rule,
                $handler,
                Arr::get($validator, 'message')
            );
        }

        return $factory->make($data, $rules);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Arr::make(Hydrator::dehydrate($this));
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Return a string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
