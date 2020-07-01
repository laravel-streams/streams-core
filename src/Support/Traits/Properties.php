<?php

namespace Anomaly\Streams\Platform\Support\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/**
 * Trait Properties
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Properties
{

    /**
     * The attribute values.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The object properties.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->buildProperties();

        $this->fill($attributes);
    }

    /**
     * Fill the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Return the key expression value
     * from the attribuets array.
     * 
     * Or default.
     * 
     * @param mixed $key
     * @param null $default
     * @return mixed
     */
    public function attr($key, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }

    /**
     * Expand an attribute value.
     *
     * @param string $key
     * @return mixed
     */
    public function expand($key)
    {
        return $this->expandAttributeValue($key, $this->getAttributes()[$key] ?? $this->propertyDefault($key));
    }

    /**
     * Get an attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (
            $this->offsetExists($key) ||
            $this->hasAttributeGetter($key) ||
            $this->hasAttributeType($key)
        ) {
            return $this->getAttributeValue($key);
        }

        return $this->attr($key, $this->propertyDefault($key));
    }

    /**
     * Return the attribute's value.
     *
     * @param string $key
     */
    public function getAttributeValue($key)
    {
        return $this->transformAttributeValue($key, $this->getAttributes()[$key] ?? $this->propertyDefault($key));
    }

    /**
     * Set the attribute's value.
     *
     * @param string $key
     */
    public function setAttributeValue($key, $value)
    {
        $this->attributes[$key] = $this->transformAttributeValue($key, $value);

        return $this;
    }

    /**
     * Return a properties default value.
     *
     * @param string $key
     */
    protected function propertyDefault($key)
    {
        return Arr::get($this->properties, $key . '.default');
    }

    /**
     * Transform the attribute value via mutators, types, etc.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function transformAttributeValue($key, $value)
    {
        /**
         * Mutators may step in
         * and handle transforming.
         */
        if ($this->hasAttributeGetter($key)) {
            return $this->mutateAttributeValue($key, $value);
        }

        /**
         * If the attribute is defined by a type
         * then let the type class cast the value.
         */
        if ($this->hasAttributeType($key)) {
            return $this->typeCastAttributeValue($key, $value);
        }

        return $value;
    }
    
    /**
     * Expand the attribute value.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function expandAttributeValue($key, $value)
    {
        /**
         * Mutators may step in
         * and handle transforming.
         */
        // if ($this->hasAttributeGetter($key)) {
        //     return $this->mutateAttributeValue($key, $value);
        // }

        $type = $this->properties[$key]['type'];

        // switch ($type) {

        //     case 'int':
        //     case 'integer':

        //         return (int) $value;

        //     case 'real':
        //     case 'float':
        //     case 'double':

        //         switch ((string) $value) {
        //             case 'Infinity':
        //                 return INF;
        //             case '-Infinity':
        //                 return -INF;
        //             case 'NaN':
        //                 return NAN;
        //             default:
        //                 return (float) $value;
        //         }

        //     case 'decimal':

        //         return number_format($value, explode(':', $this->getCasts()[$key], 2)[1]);

        //     case 'string':

        //         return (string) $value;

        //     case 'bool':
        //     case 'boolean':

        //         return filter_var($value, FILTER_VALIDATE_BOOL);

        //     case 'object':

        //         return json_decode($value);

        //     case 'array':
        //     case 'json':

        //         if (!is_string($value)) {
        //             return $value;
        //         }

        //         return json_decode($value, true);

        //     case 'collection':

        //         return new Collection($this->json_decode($value, true));

        //     case 'datetime':
        //     case 'custom_datetime':

        //         return $this->castDateTimeAttribute($value);

        //     case 'date':

        //         return $this->castDateTimeAttribute($value)->startOfDay();

        //     case 'timestamp':

        //         return $this->castDateTimeAttribute($value)->getTimestamp();
        // }

        // @todo would prefer this but resolve for now
        //$type = new $type($this->properties[$key]);
        $type = app($type, $this->properties[$key]);

        $type->field = $key;
        // @todo fill type here or use FieldTypeBuilder::build

        return $type->expand($value);
    }

    /**
     * Set an attribute value.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if (
            $this->offsetExists($key) ||
            $this->hasAttributeSetter($key) ||
            $this->hasAttributeType($key)
        ) {
            return $this->setAttributeValue($key, $value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get the properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param string  $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    // ------------------------  ARRAY ACCESS  ---------------------------

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->attributes[] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    // ------------------------  LOCAL UTILITY  ---------------------------

    /**
     * Build property definitions.
     *
     * @return void
     */
    protected function buildProperties()
    {

        /**
         * If we don't have any attributes
         * then we have nothing to do at all.
         * 
         * Can't guess and don't need anything!
         */
        if (!isset($this->attributes)) {
            return;
        }

        /**
         * If we have properties defined
         * then we can skip this step.
         */
        if (!empty($this->properties)) {
            return;
        }

        /**
         * Build the properties from
         * default attribute values.
         */
        $this->properties = array_map(function ($attribute) {

            /**
             * Type sniff the attribute value.
             */
            // $type = gettype($attribute);

            // /**
            //  * Default type is string.
            //  */
            // if ($type === 'NULL') {
            //     $type = 'string';
            // }

            // /**
            //  * "double" is returned in lieue
            //  * of float for historical reasons.
            //  */
            // if ($type === 'double') {
            //     $type = 'float';
            // }

            /**
             * Default property definition.
             */
            $attribute = [
                //'type' => $type,
                'default' => $attribute,
            ];

            return $attribute;
        }, $this->attributes);

        $this->attributes['__initialized'] = true;
    }

    /**
     * Return if the object has an attribute getter.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasAttributeGetter($key)
    {
        // if (self::hasMacro('get_', $key . '_attribute')) {
        //     return true;
        // }

        if (method_exists($this, Str::studly('get_' . $key . '_attribute'))) {
            return true;
        }

        return false;
    }

    /**
     * Return if the object has an attribute setter.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasAttributeSetter($key)
    {
        // if ($this->hasHook('set_', $key . '_attribute')) {
        //     return true;
        // }

        if (method_exists($this, Str::studly('get_' . $key . '_attribute'))) {
            return true;
        }

        return false;
    }

    /**
     * Run the attribute mutator
     * and return the value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed|null
     */
    public function mutateAttributeValue($key, $value)
    {
        // if ($this->hasHook($hook = 'get_', $key . '_attribute')) {
        //     return $this->call($hook, compact('value'));
        // }

        if (method_exists($this, $method = Str::studly('get_' . $key . '_attribute'))) {
            return $this->{$method}($value);
        }

        return $value;
    }

    /**
     * Run the attribute type
     * cast and return the value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function typeCastAttributeValue($key, $value)
    {
        $type = $this->properties[$key]['type'];

        switch ($type) {

            case 'int':
            case 'integer':

                return (int) $value;

            case 'real':
            case 'float':
            case 'double':

                switch ((string) $value) {
                    case 'Infinity':
                        return INF;
                    case '-Infinity':
                        return -INF;
                    case 'NaN':
                        return NAN;
                    default:
                        return (float) $value;
                }

            case 'decimal':

                return number_format($value, explode(':', $this->getCasts()[$key], 2)[1]);

            case 'string':

                return (string) $value;

            case 'bool':
            case 'boolean':

                return filter_var($value, FILTER_VALIDATE_BOOL);

            case 'object':

                return json_decode($value);

            case 'json':
            case 'array':
            case 'collection':

                if (!is_string($value)) {
                    return $value;
                }

                return json_decode($value, true);

            // case 'collection':

            //     return new Collection($this->json_decode($value, true));

            case 'datetime':
            case 'custom_datetime':

                return $this->castDateTimeAttribute($value);

            case 'date':

                return $this->castDateTimeAttribute($value)->startOfDay();

            case 'timestamp':

                return $this->castDateTimeAttribute($value)->getTimestamp();
        }

        // @todo would prefer this but resolve for now
        //$type = new $type($this->properties[$key]);
        $type = app($type, $this->properties[$key]);

        $type->field = $key;
        // @todo fill type here or use FieldTypeBuilder::build

        return $type->restore($value);
    }

    /**
     * Cast the value to a datetime instance.
     *
     * @param mixed $value
     */
    public function castDateTimeAttribute($value)
    {
        // If this value is already a Carbon instance, we shall just return it as is.
        // This prevents us having to re-instantiate a Carbon instance when we know
        // it already is one, which wouldn't be fulfilled by the DateTime check.
        if ($value instanceof CarbonInterface) {
            return Date::instance($value);
        }

        // If the value is already a DateTime instance, we will just skip the rest of
        // these checks since they will be a waste of time, and hinder performance
        // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            return Date::parse(
                $value->format('Y-m-d H:i:s.u'),
                $value->getTimezone()
            );
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            return Date::createFromTimestamp($value);
        }

        // If the value is in simply year, month, day format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple date
        // fields on the database, while still supporting Carbonized conversion.
        if ($this->isStandardDateFormat($value)) {
            return Date::instance(Carbon::createFromFormat('Y-m-d', $value)->startOfDay());
        }

        $format = $this->getDateFormat();

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        if (Date::hasFormat($value, $format)) {
            return Date::createFromFormat($format, $value);
        }

        return Date::parse($value);
    }

    /**
     * Determine if the given value is a standard date format.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isStandardDateFormat($value)
    {
        return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value);
    }

    /**
     * Return if the object has an attribute type.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasAttributeType($key)
    {
        return isset($this->properties) ? Arr::get($this->properties, $key . '.type') : false;
    }
}
