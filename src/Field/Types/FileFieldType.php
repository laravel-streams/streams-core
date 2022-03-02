<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Arr;
use Streams\Core\Field\Presenter\FilePresenter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileFieldType extends StringFieldType
{
    
    public function cast($value)
    {
        if (is_string($value)) {
            return $value;
        }

        if ($value instanceof \SplFileObject) {
            dd($value);
        }

        if ($value instanceof UploadedFile) {

            if (!$path = Arr::get($this->config, 'path')) {
                throw new \Exception("Value [config.path] is required for [{$this->field}].");
            }
            
            return $value->storeAs($path, $value->getClientOriginalName());
        }

        throw new \Exception("Could not determine file type.");
    }

    public function getPresenterName()
    {
        return FilePresenter::class;
    }
}
