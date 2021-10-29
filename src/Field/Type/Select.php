<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Factory\SelectGenerator;

class Select extends FieldType
{

    public function options()
    {
        return $this->once(__METHOD__, function () {

            $options = $this->field->config('options', []);

            if (is_string($options)) {
                return App::call($options);
            }

            return $options;
        });
    }

    public function generator(): SelectGenerator
    {
        return new SelectGenerator($this);
    }
}
