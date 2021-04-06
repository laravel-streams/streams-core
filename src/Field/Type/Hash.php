<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support;
use Streams\Core\Field\Value\HashValue;
use Illuminate\Support\Facades\Hash as FacadesHash;

class Hash extends Str
{
    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (strpos($value, '$2y$') === 0) {
            return $value;
        }

        $prefix = Support\Arr::get($this->config, 'prefix');

        if ($prefix && Support\Str::startsWith($value, $prefix)) {
            throw new \Exception("Value [{$value}] is already hashed.");
        }

        return $prefix . FacadesHash::make($value);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new HashValue($value);
    }
}
