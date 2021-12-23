<?php

namespace Streams\Core\Schema\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\BaseObject;
use GoldSpecDigital\ObjectOrientedOAS\Utilities\Arr;

class Filter extends BaseObject
{
    const FUNC_EQUALS = 'equals';
    const FUNC_SCHEMA_EXISTS = 'schema-exists';
    const FUNC_DATA_EXISTS = 'data-exists';
    const FUNC_GLOBAL_EXISTS = 'global-exists';
    const FUNC_SLOT_EXISTS = 'slot-exists';
    const FUNC_FILTER_EXISTS = 'filter-exists';
    const FUNC_FORMAT_EXISTS = 'format-exists';
    const FUNC_REGEX = 'regex';
    const FUNC_MIN_DATE = 'min-date';
    const FUNC_MAX_DATE = 'max-date';
    const FUNC_NOT_DATE = 'not-date';
    const FUNC_MIN_TIME = 'min-time';
    const FUNC_MAX_TIME = 'max-time';
    const FUNC_MIN_DATETIME = 'min-datetime';
    const FUNC_MAX_DATETIME = 'max-datetime';

    protected $func;

    /** @var array|null */
    protected $vars;

    public static function equals($var, bool $strict): self
    {
        $instance       = new static();
        $instance->func = self::FUNC_EQUALS;
        $instance->vars = compact('var', 'strict');
        return $instance;
    }

    public function vars(array $vars): self
    {
        $instance = clone $this;

        $instance->vars = $vars;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            '$func' => $this->func,
            '$vars' => $this->vars,
        ]);
    }

}
