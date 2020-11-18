<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use Streams\Core\Repository\Repository;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Criteria\Contract\CriteriaInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;

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
        foreach ($fieldRules as $field => $configured) {
            $rules[$field] = array_merge(Arr::get($rules, $field, []), $configured);
        }

        foreach ($fieldValidators as $field => $configured) {
            $validators[$field] = array_merge(Arr::get($validators, $field, []), $configured);
        }

        /**
         * Stringify rules for Laravel.
         */
        $rules = array_map(function ($rules) {
            return implode('|', array_unique($rules));
        }, $rules);

        /**
         * Extend the factory with custom validators.
         */
        foreach ($validators as $rule => $validator) {

            $handler = Arr::get($validator, 'handler');

            if (strpos($handler, '@')) {
                
                $handler = function ($attribute, $value, $parameters, Validator $validator) use ($handler) {

                    return App::call(
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
