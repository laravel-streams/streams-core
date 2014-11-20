<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

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
     * These keys are NOT attributes.
     *
     * @var array
     */
    protected $notAttributes = [
        'url',
        'class',
        'title',
        'active',
    ];

    /**
     * Handle the command.
     *
     * @param BuildTableViewsCommand $command
     * @return array
     */
    public function handle(BuildTableViewsCommand $command)
    {
        $table = $command->getTable();

        $views     = $table->getViews();
        $presets   = $table->getPresets();
        $expander  = $table->getExpander();
        $evaluator = $table->getEvaluator();

        /**
         * Loop through and process the view configurations
         * for the table view.
         */
        foreach ($views as $slug => &$view) {

            // Expand and automate.
            $view = $expander->expand($slug, $view);
            $view = $presets->setViewPresets($view);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($view['handler']);

            // Evaluate the entire view.
            $view = $evaluator->evaluate($view, compact('table'));

            // Skip if disabled.
            if (array_get($view, 'enabled') === false) {

                unset($view[$slug]);

                continue;
            }

            // Build out required data.
            $url    = $this->getUrl($view, $table);
            $title  = $this->getTitle($view, $table);
            $class  = $this->getClass($view, $table);
            $active = $this->getActive($view, $table);

            $attributes = attributes_string($view, $this->notAttributes);

            $views = compact('url', 'title', 'class', 'active', 'attributes');
        }

        return $views;
    }

    /**
     * Get the class.
     *
     * @param array $view
     * @param Table $table
     * @return mixed
     */
    protected function getClass(array $view, Table $table)
    {
        $class = array_get($view, 'class');

        return $class;
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
        return trans(array_get($view, 'title', 'misc.all', [$table]));
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
     * Get active flag.
     *
     * @param array $view
     * @param Table $table
     * @return bool
     */
    protected function getActive(array $view, Table $table)
    {
        $executing = app('request')->get($table->getPrefix() . 'view');

        if ($executing == $view['slug'] or array_search($view['slug'], array_keys($table->getViews()))) {

            return true;
        }

        return false;
    }
}
 