<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Ui\Form\FormPresenter;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class Table
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Table
{

    use HasAttributes;

    /**
     * The link attributes.
     *
     * @var array
     */
    protected $attributes = [
        // 'rows' => null,
        // 'views' => null,
        // 'stream' => null,
        // 'actions' => null,
        // 'entries' => null,
        // 'filters' => null,
        // 'headers' => null,
        // 'options' => null,
    ];

    /**
     * Return a created presenter.
     *
     * @return FormPresenter
     */
    public function newPresenter()
    {
        $presenter = get_class($this) . 'Presenter';

        if (class_exists($presenter)) {
            return App::make($presenter, ['object' => $this]);
        }

        return App::make(TablePresenter::class, ['object' => $this]);
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
     * Render the table.
     * 
     * @return View
     */
    public function render()
    {
        return View::make('streams::table/table', ['table' => $this]);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Arr::make(Hydrator::dehydrate($this));
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
