<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;

class Select extends FieldType
{

    public function options()
    {
        return $this->once(__METHOD__, function () {

            $options = Arr::get($this->field->config, 'options', []);

            if (is_string($options)) {
                return App::call($options);
            }
        });
    }
}
