<?php namespace Anomaly\Streams\Platform\Ui\Grid;

use Illuminate\Support\Facades\View;
use Anomaly\Streams\Platform\Ui\Tree\GridPresenter;
use Anomaly\Streams\Platform\Support\Traits\Properties;

/**
 * Class Grid
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Grid
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
        return View::make('streams::grid/grid', ['grid' => decorate($this)]);
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

        return app()->make(GridPresenter::class, ['object' => $this]);
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
