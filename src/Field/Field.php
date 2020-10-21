<?php

namespace Streams\Core\Field;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Field\Contract\FieldInterface;

/**
 * Class Field
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Field implements FieldInterface, Arrayable, Jsonable
{
    use HasMemory;
    use Macroable;
    use Prototype;

    /**
     * Return the type instance.
     * 
     * @return FieldType
     */
    public function type(): FieldType
    {
        return $this->remember($this->handle . '.' . $this->type, function () {

            $type = App::make('streams.field_types.' . $this->type);

            $type->field = $this->handle;
            $type->parent = $this;
            
            // if (isset($this->stream->model->id)) {
            //     $type->setEntry($this->stream->model);
            // }

            return $type;
        });
    }

    public function toArray(): array
    {
        return Hydrator::dehydrate($this);
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
