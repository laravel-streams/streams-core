<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\Properties;

/**
 * Class Tree
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Tree implements Arrayable, Jsonable
{

    use Properties;

    /**
     * The link attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Render the table.
     * 
     * @return View
     */
    public function render()
    {
        return View::make('streams::tree/tree', ['tree' => decorate($this)]);
    }

    /**
     * Return a created presenter.
     *
     * @return FormPresenter
     */
    public function newPresenter()
    {
        $presenter = get_class($this) . 'Presenter';

        if (class_exists($presenter)) {
            return app()->make($presenter, ['object' => $this]);
        }

        return app()->make(TreePresenter::class, ['object' => $this]);
    }

    /**
     * Return a prefixed target.
     *
     * @param string $target
     * @return string
     */
    public function prefix($target = null)
    {
        return $this->options->get('prefix') . $target;
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
}
