<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Presenter\NumberPresenter;
use Streams\Core\Field\Schema\NumberSchema;

class NumberFieldType extends Field
{
    protected $__attributes = [
        'rules' => [
            'numeric',
        ],
    ];

    public function cast($value): float|int
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        $float = floatval($value);

        if ($float && intval($float) != $float) {
            $value = $float;
        } else {
            $value = intval($value);
        }

        return $value;
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function getPresenterName()
    {
        return NumberPresenter::class;
    }

    public function getSchemaName()
    {
        return NumberSchema::class;
    }

    public function generate()
    {
        return $this->generator()->randomElement([
            $this->generator()->randomNumber(),
            $this->generator()->randomFloat(),
            round($this->generator()->randomFloat(), 1),
        ]);
    }
}
