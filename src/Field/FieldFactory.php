<?php

namespace Streams\Core\Field;

use Illuminate\Support\Facades\App;

class FieldFactory
{

    protected Field $field;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    public function generator()
    {
        return App::make('streams.faker');
    }

    public function min()
    {
        if (!$this->field->hasRule('min')) {
            return null;
        }

        return $this->field->ruleParameter('min');
    }

    public function max()
    {
        if (!$this->field->hasRule('max')) {
            return null;
        }

        return $this->field->ruleParameter('max');
    }
}
