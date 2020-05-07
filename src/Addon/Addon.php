<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Presenter;
use Anomaly\Streams\Platform\Traits\Presentable;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class Addon
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Addon implements Arrayable, Jsonable
{

    use Hookable;
    use HasMemory;
    use Presentable;
    use HasAttributes;
    use FiresCallbacks;

    /**
     * The addon attributes.
     *
     * @var array
     */
    protected $attributes = [
        'path' => null,
        'type' => null,
    ];

    /**
     * The addon slug.
     *
     * @var string
     */
    protected $slug;

    /**
     * Get the name.
     *
     * @var null|string
     */
    protected $name;

    /**
     * Get the title.
     *
     * @var null|string
     */
    protected $title;

    /**
     * Get the title.
     *
     * @var null|string
     */
    protected $description;

    /**
     * The addon vendor.
     *
     * @var string
     */
    protected $vendor;

    /**
     * The addon namespace.
     *
     * @var null|string
     */
    protected $namespace;

    /**
     * The sub-addons to load.
     *
     * @var array
     */
    protected $addons = [];

    /**
     * The enabled flag.
     *
     * @var bool
     */
    public $enabled = false;

    /**
     * The installed flag.
     *
     * @var bool
     */
    public $installed = false;

    /**
     * The addon presenter.
     *
     * @var string|Presenter
     */
    protected $presenter = AddonPresenter::class;

    /**
     * Set the installed flag.
     *
     * @param  $installed
     * @return $this
     */
    public function setInstalled($installed)
    {
        $this->installed = $installed;

        return $this;
    }

    /**
     * Get the installed flag.
     *
     * @return bool
     */
    public function isInstalled()
    {
        return $this->installed;
    }

    /**
     * Set the enabled flag.
     *
     * @param  $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get the enabled flag.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled && $this->installed;
    }

    /**
     * Return whether the addon is core or not.
     *
     * @return bool
     */
    public function isCore()
    {
        return str_contains($this->path, 'core/' . $this->getVendor());
    }

    /**
     * Return whether the addon is shared or not.
     *
     * @return bool
     */
    public function isShared()
    {
        return str_contains($this->path, 'addons/shared/' . $this->getVendor());
    }

    /**
     * Return whether the addon is for testing or not.
     *
     * @return bool
     */
    public function isTesting()
    {
        return str_contains($this->path, 'vendor/anomaly/streams-platform/addons/' . $this->getVendor());
    }

    /**
     * Get the addon name string.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name ?: $this->getNamespace('addon.name');
    }

    /**
     * Get the addon description string.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description ?: $this->getNamespace('addon.description');
    }

    /**
     * Get a namespaced key string.
     *
     * @param  null $key
     * @return string
     */
    public function getNamespace($key = null)
    {
        if (!$this->namespace) {
            $this->makeNamespace();
        }

        return $this->namespace . ($key ? '::' . $key : $key);
    }

    /**
     * Return whether an addon has
     * config matching the key.
     *
     * @param  string $key
     * @return boolean
     */
    public function hasConfig($key = '*')
    {
        return (bool) config($this->getNamespace($key));
    }

    /**
     * Return whether an addon has
     * config matching any key.
     *
     * @param  array $keys
     * @return bool
     */
    public function hasAnyConfig(array $keys = ['*'])
    {
        foreach ($keys as $key) {
            if ($this->hasConfig($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the composer json contents.
     *
     * @return mixed|null
     */
    public function getComposerJson()
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
    public function getComposerLock()
    {
        $self = $this;

        $target = $self->getPackageName();

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
    public function getReadme()
    {
        $self = $this;

        return $this->once($this->getNamespace('README'), function () use ($self) {

            $readme = $self->path('README.md');

            return file_get_contents($readme);
        });
    }

    /**
     * Return the package name.
     *
     * @return string
     */
    public function getPackageName()
    {
        return $this->getVendor() . '/' . $this->getSlug() . '-' . $this->getType();
    }

    /**
     * Return an addon path.
     *
     * @return string
     */
    public function path($path = null)
    {
        return $this->path . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Return the app path.
     *
     * @param null $path
     */
    public function getAppPath($path = null)
    {
        return ltrim(str_replace(base_path(), '', $this->path($path)), DIRECTORY_SEPARATOR);
    }

    /**
     * Set the addon slug.
     *
     * @param  $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the addon slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the addon type.
     *
     * @param  $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the addon type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the vendor.
     *
     * @param $vendor
     * @return $this
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get the vendor.
     *
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Get the sub-addons.
     *
     * @return array
     */
    public function getAddons()
    {
        return $this->addons;
    }

    /**
     * Make the addon namespace.
     */
    protected function makeNamespace()
    {
        $this->namespace = "{$this->getVendor()}.{$this->getType()}.{$this->getSlug()}";
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
