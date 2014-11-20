<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TablePresets;

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
     * @var \Anomaly\Streams\Platform\Ui\Table\TablePresets
     */
    protected $utility;

    /**
     * Create a new BuildTableViewsCommandHandler instance.
     *
     * @param TablePresets $utility
     */
    function __construct(TablePresets $utility)
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

        $count = 0;

        $table = $command->getTable();

        foreach ($table->getViews() as $slug => $view) {

            // Standardize input.
            $view = $this->standardize($slug, $view);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($view['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $view = $this->utility->evaluate($view, [$table]);

            // Skip if disabled.
            if (!evaluate_key($view, 'enabled', true)) {

                continue;
            }

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($view, $table);

            $view = array_merge($defaults, $view);

            // Build out required data.
            $url    = $this->getUrl($view, $table);
            $title  = $this->getTitle($view, $table);
            $class  = $this->getClass($view, $table);
            $active = $this->getActive($view, $count, $table);

            $views[] = compact('url', 'title', 'class', 'active');

            $count++;
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
     * @param $table
     * @return array|mixed|null
     */
    protected function getDefaults($view, $table)
    {
        if (isset($view['type']) and $defaults = $this->utility->getViewDefaults($view['type'])) {

            return $this->utility->evaluate($defaults, [$table]);
        }

        return [];
    }

    /**
     * Get the view URL.
     *
     * @param array $view
     * @param Table $table
     * @return string
     */
    protected function getUrl(array $view, Table $table)
    {
        return url(app('request')->path()) . '?' . $table->getPrefix() . 'view=' . $view['slug'];
    }

    /**
     * Get the translated view title.
     *
     * @param array $view
     * @param Table $table
     * @return string
     */
    protected function getTitle(array $view, Table $table)
    {
        return trans(evaluate_key($view, 'title', 'misc.all', [$table]));
    }

    /**
     * Get the view class.
     *
     * @param array   $view
     * @param         $order
     * @param Table   $table
     * @return mixed|null|string
     */
    protected function getClass(array $view, Table $table)
    {
        $class = evaluate_key($view, 'class', '', [$table]);

        return $class;
    }

    /**
     * Get active flag.
     *
     * @param array   $view
     * @param         $count
     * @param Table   $table
     * @return string
     */
    protected function getActive(array $view, $count, Table $table)
    {
        $input = app('request');

        $executing = $input->get($table->getPrefix() . 'view');

        if (($executing == $view['slug']) or (!$executing and $count == 0)) {

            return true;
        }

        return false;
    }
}
 