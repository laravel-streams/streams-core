<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Streams\Core\Field\Value\FileValue;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Str
{
    
    public function modify($value)
    {
        if (is_string($value)) {
            return $value;
        }

        if (!$path = Arr::get($this->config, 'path')) {
            throw new \Exception("Value [config.path] is required for [{$this->field}].");
        }

        if ($value instanceof \SplFileObject) {
            dd($value);
        }

        if ($value instanceof UploadedFile) {
            return $value->storeAs($path, $value->getClientOriginalName());
        }

        throw new \Exception("Could not determine file type.");
    }

    public function getValueName()
    {
        return FileValue::class;
    }
}
