<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\BuildWorkflow;

/**
 * Class TreeBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TreeBuilder
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
            //'async' => false,
            //'handler' => null,
            'stream' => null,
            'repository' => null,
            
            'entry' => null,
            
            'assets' => [],
            'options' => [],
            'buttons' => [],
            'segments' => [],
            
            'tree' => Tree::class,
        ]);

        $this->buildProperties();

        $this->fill($attributes);
    }

    /**
     * Build and return the tree instance.
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
     * Render the tree.
     *
     * @return View
     */
    public function render()
    {
        $this->build();

        return $this->tree->render();
    }

    /**
     * Return the tree response.
     * 
     * @return Response
     */
    public function response()
    {
        if (false/* is async request */) {
            return $this->json();
        }

        return Response::view('streams::default', ['content' => $this->render()]);
    }

    /**
     * Return a JSON response.
     *
     * @return JsonResponse
     */
    public function json()
    {
        $this->build();

        return Response::json($this->tree->toJson());
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
        return Request::get($this->tree->options->get('prefix') . $key, $default);
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
        return Request::post($this->tree->options->get('prefix') . $key, $default);
    }
}
