<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;

/**
 * Class Addon
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Addon implements Arrayable, Jsonable
{

    use Macroable;
    use HasMemory;
    use Properties;
    use FiresCallbacks;

    
    /**
     * Return whether the addon is core or not.
     *
     * @return bool
     */
    public function inVendor()
    {
        return Str::contains(__DIR__, base_path('vendor'));
    }

    /**
     * Return whether the addon is shared or not.
     *
     * @return bool
     */
    public function isShared()
    {
        return Str::contains(__DIR__, base_path('addons/shared'));
    }

    /**
     * Get the composer json contents.
     *
     * @return mixed|null
     */
    public function composerJson()
    {
        $self = $this;

        return $this->once($this->getNamespace('composer.json'), function () use ($self) {

            $composer = $self->path('composer.json');

            return json_decode(file_get_contents($composer), true);
        });
    }

    /**
     * Get the composer json contents.
     *
     * @return array|null
     */
    public function lockInformation()
    {
        $target = $this->package;

        return $this->once($this->getNamespace('composer.lock'), function () use ($self, $target) {

            $lock = base_path('composer.lock');

            $json = json_decode(file_get_contents($lock), true);

            return array_first(
                $json['packages'],
                function (array $package) use ($target) {
                    return $package['name'] == $target;
                }
            );
        });
    }

    /**
     * Get the README.md contents.
     *
     * @return string|null
     */
    public function readme()
    {
        $self = $this;

        return $this->once($this->getNamespace('README'), function () use ($self) {

            $readme = $self->path('README.md');

            return file_get_contents($readme);
        });
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
