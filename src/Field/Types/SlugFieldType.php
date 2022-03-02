<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Presenter\StringPresenter;

class SlugFieldType extends Field
{
    public function cast($value)
    {
        return Str::slug($value, $this->config('seperator') ?: '_');
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
        return StringPresenter::class;
    }

    public function generate()
    {
        return $this->modify($this->generator()->words(2, true));
    }
}
