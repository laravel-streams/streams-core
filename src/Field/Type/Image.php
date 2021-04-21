<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Streams\Core\Field\Value\ImageValue;

class Image extends File
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeInstance(array $attributes)
    {
        return array_merge([
            'rules' => [],
        ], $attributes);
    }
    
    /**
     * Expand the value.
     *
     * @param $value
     * @return \Streams\Core\Image\Image
     */
    public function expand($value)
    {
        return new ImageValue($value);
    }
}
