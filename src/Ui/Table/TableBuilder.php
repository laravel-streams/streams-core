<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Ui\Table\Workflows\BuildWorkflow;

/**
 * Class TableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableBuilder
{

    use Properties;
    use FiresCallbacks;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes([
            'async' => false,

            'stream' => null,
            'entries' => null,
            'repository' => null,

            'views' => [],
            'assets' => [],
            'filters' => [],
            'columns' => [],
            'buttons' => [],
            'actions' => [],
            'options' => [],

            'table' => Table::class,
        ]);

        $this->buildProperties();

        $this->fill($attributes);
    }

    /**
     * Build and return the table instance.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->built === true) {
            return $this;
        }

        $this->fire('ready', ['builder' => $this]);

        (new BuildWorkflow)->process(['builder' => $this]);

        $this->fire('built', ['builder' => $this]);

        $this->built = true;

        return $this;
    }

    /**
     * Render the table.
     *
     * @return View
     */
    public function render()
    {
        $this->build();

        return $this->table->render();
    }

    /**
     * Return the table response.
     * 
     * @return Response
     */
    public function response()
    {
        if (false/* is async request */) {
            return $this->json();
        }

        return $this->view();
    }

    /**
     * Return a JSON response.
     *
     * @return JsonResponse
     */
    public function json()
    {
        $this->build();

        return Response::json($this->table->toJson());
    }

    /**
     * Return a view response.
     * 
     * @return View
     */
    public function view()
    {
        return Response::view('streams::default', ['content' => $this->render()]);
    }

    /**
     * Get a request value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function request($key, $default = null)
    {
        return Request::get($this->table->options->get('prefix') . $key, $default);
    }

    /**
     * Get a post value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return Request::post($this->table->options->get('prefix') . $key, $default);
    }
}
