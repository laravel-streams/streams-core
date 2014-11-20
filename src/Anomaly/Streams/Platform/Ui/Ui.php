<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Traits\CallableTrait;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Traits\TransformableTrait;

/**
 * Class Ui
 *
 * The base UI class.
 * All other UI classes extend this one.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Ui
{

    use CallableTrait;
    use CommandableTrait;
    use DispatchableTrait;
    use TransformableTrait;

    /**
     * The view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The response object sent back
     * to the controller or wherever.
     *
     * @var
     */
    protected $response = null;

    /**
     * The UI prefix. This helps us
     * distinguish logic for multiple
     * instances of a UI.
     *
     * @var string
     */
    protected $prefix = 'ui';

    /**
     * The wrapper view.
     *
     * @var string
     */
    protected $wrapperView = 'wrappers/blank';

    /**
     * The page title.
     *
     * @var string
     */
    protected $title = 'misc.untitled'; // TODO: Could pry do better than this default.

    /**
     * The model object.
     *
     * @var mixed
     */
    protected $model = null;

    /**
     * The utility object.
     *
     * @var Utility
     */
    protected $utility;

    /**
     * The expander object.
     *
     * @var Expander
     */
    protected $expander;

    /**
     * The evaluator object.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * The normalizer object.
     *
     * @var Normalizer
     */
    protected $normalizer;

    /**
     * Create a new Ui instance.
     */
    public function __construct()
    {
        $this->utility    = $this->newUtility();
        $this->expander   = $this->newExpander();
        $this->evaluator  = $this->newEvaluator();
        $this->normalizer = $this->newNormalizer();

        $this->boot();
    }

    /**
     * Setup the class.
     */
    protected function boot()
    {
    }

    /**
     * Trigger the response.
     */
    protected function trigger()
    {
        return null;
    }

    /**
     * Make the response.
     *
     * @return \Illuminate\View\View
     */
    public function make()
    {
        $content = $this->trigger();

        $title = trans(evaluate($this->title, [$this]));

        return view($this->wrapperView, compact('content', 'title'));
    }

    /**
     * Render the response.
     *
     * @return mixed|null
     */
    public function render()
    {
        return $this->make();
    }

    /**
     * Set the response object. This is really
     * helpful when the response is decided
     * miles away in an event or something.
     *
     * @param mixed $response
     * return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Set the UI prefix.
     *
     * @param string $prefix
     * return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the UI prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        if ($this->prefix) {

            return $this->prefix . (ends_with($this->prefix, '_') ? : '_');
        }

        return $this->prefix;
    }

    /**
     * Set the model object.
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model object.
     *
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the title.
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the view wrapper.
     *
     * @param $view
     * @return $this
     */
    public function setWrapperView($view)
    {
        $this->wrapperView = $view;

        return $this;
    }

    /**
     * Set the view data.
     *
     * @param array $data
     * return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the evaluator object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Evaluator
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     * Get the expander object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Expander
     */
    public function getExpander()
    {
        return $this->expander;
    }

    /**
     * Get the normalizer object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Normalizer
     */
    public function getNormalizer()
    {
        return $this->normalizer;
    }

    /**
     * Get the utility object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Utility
     */
    public function getUtility()
    {
        return $this->utility;
    }

    /**
     * Return the utility counterpart object.
     *
     * @return Utility
     */
    protected function newUtility()
    {
        if (!$utility = $this->transform(__METHOD__)) {

            $utility = 'Anomaly\Streams\Platform\Ui\Utility';
        }

        return app($utility);
    }

    /**
     * Return the expander counterpart object.
     *
     * @return Expander
     */
    protected function newExpander()
    {
        if (!$expander = $this->transform(__METHOD__)) {

            $expander = 'Anomaly\Streams\Platform\Ui\Expander';
        }

        return app($expander);
    }

    /**
     * Return the evaluator counterpart object.
     *
     * @return Evaluator
     */
    protected function newEvaluator()
    {
        if (!$evaluator = $this->transform(__METHOD__)) {

            $evaluator = 'Anomaly\Streams\Platform\Ui\Evaluator';
        }

        return app($evaluator);
    }

    /**
     * Return the normalizer counterpart object.
     *
     * @return mixed
     */
    protected function newNormalizer()
    {
        if (!$normalizer = $this->transform(__METHOD__)) {

            $normalizer = 'Anomaly\Streams\Platform\Ui\Normalizer';
        }

        return app($normalizer);
    }
}
