<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableUtility;

/**
 * Class BuildTableViewsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableViewsCommandHandler
{

    /**
     * The table utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
     */
    protected $utility;

    /**
     * Create a new BuildTableViewsCommandHandler instance.
     *
     * @param TableUtility $utility
     */
    function __construct(TableUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildTableViewsCommand $command
     * @return array
     */
    public function handle(BuildTableViewsCommand $command)
    {
        $views = [];

        $ui = $command->getUi();

        foreach ($ui->getViews() as $slug => $view) {

            // Standardize input.
            $view = $this->standardize($slug, $view);

            // We care about the first by default.
            $order = array_search('blah', array_keys($ui->getViews()));

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($view['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $view = $this->utility->evaluate($view, [$ui]);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($view, $ui);

            $view = array_merge($defaults, $view);

            // Build out required data.
            $url    = $this->getUrl($view, $ui);
            $title  = $this->getTitle($view, $ui);
            $class  = $this->getClass($view, $ui);
            $active = $this->getActive($view, $order, $ui);

            $views[] = compact('url', 'title', 'class', 'active');
        }

        return $views;
    }

    /**
     * Standardize minimum input to the proper data
     * structure that we actually need.
     *
     * @param $slug
     * @param $view
     * @return array
     */
    protected function standardize($slug, $view)
    {

        /**
         * If the slug is numerical and the view
         * is a string then use view for both.
         */
        if (is_numeric($slug) and is_string($view)) {

            return [
                'type' => $view,
                'slug' => $view,
            ];
        }

        /**
         * If the slug is a string and the view
         * is too then use the slug as slug and
         * the view as the type.
         */
        if (is_string($view)) {

            return [
                'type' => $view,
                'slug' => $slug,
            ];
        }

        /**
         * If the slug is not explicitly set
         * then default it to the slug inferred.
         */
        if (is_array($view) and !isset($view['slug'])) {

            $view['slug'] = $slug;
        }

        return $view;
    }

    /**
     * Get default configuration if any.
     * Then run everything back through evaluation.
     *
     * @param $view
     * @param $ui
     * @return array|mixed|null
     */
    protected function getDefaults($view, $ui)
    {
        if (isset($view['type']) and $defaults = $this->utility->getViewDefaults($view['type'])) {

            return $this->utility->evaluate($defaults, [$ui]);
        }

        return [];
    }

    /**
     * Get the view URL.
     *
     * @param array $view
     * @param Table $ui
     * @return string
     */
    protected function getUrl(array $view, Table $ui)
    {
        return url(app('request')->path()) . '?' . $ui->getPrefix() . 'view=' . $view['slug'];
    }

    /**
     * Get the translated view title.
     *
     * @param array $view
     * @param Table $ui
     * @return string
     */
    protected function getTitle(array $view, Table $ui)
    {
        return trans(evaluate_key($view, 'title', 'misc.all', [$ui]));
    }

    /**
     * Get the view class.
     *
     * @param array   $view
     * @param         $order
     * @param Table   $ui
     * @return mixed|null|string
     */
    protected function getClass(array $view, Table $ui)
    {
        $class = evaluate_key($view, 'class', '', [$ui]);

        return $class;
    }

    /**
     * Get active flag.
     *
     * @param array   $view
     * @param         $order
     * @param Table   $ui
     * @return string
     */
    protected function getActive(array $view, $order, Table $ui)
    {
        $input = app('request');

        $executing = $input->get($ui->getPrefix() . 'view');

        if (($executing == $view['slug']) or (!$executing and $order == 0)) {

            return true;
        }

        return false;
    }
}
 