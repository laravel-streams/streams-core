<?php namespace Streams\Platform\Addon;

use Illuminate\Foundation\Application;
use Streams\Platform\Traits\CallableTrait;
use Streams\Platform\Contract\PresentableInterface;

class Addon implements PresentableInterface
{
    use CallableTrait;

    protected $type = 'addon'; // For testing

    protected $slug = 'abstract'; // For testing

    protected $path = null;

    protected $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function isCore()
    {
        return str_contains($this->getPath(), 'core/addons');
    }

    public function getPath($path = null)
    {
        return $this->path . ($path ? '/' . ltrim($path, '/') : null);
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
    }

    public function newPresenter()
    {
        $resource = $this;

        return app()->make('Streams\Platform\Addon\AddonPresenter', compact('resource'));
    }

    public function newServiceProvider()
    {
        return new AddonServiceProvider($this->app);
    }
}
