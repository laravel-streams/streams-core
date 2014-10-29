<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

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

        foreach ($ui->getViews() as $order => $view) {

            unset($view['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $view = $this->utility->evaluate($view, [$ui]);

            // Build out required data.
            $_url  = $this->getUrl($view);
            $title = $this->getTitle($view, $ui);
            $class = $this->getClass($view, $order, $ui);

            $views[] = compact('_url', 'title', 'class');

        }

        return $views;
    }

    /**
     * Get the view URL.
     *
     * @param $view
     * @return string
     */
    protected function getUrl($view)
    {
        return url(app('request')->path()) . '?_view=' . $view['slug'];
    }

    /**
     * Get the translated view title.
     *
     * @param $view
     * @param $ui
     * @return string
     */
    protected function getTitle($view, $ui)
    {
        return trans(evaluate_key($view, 'title', 'misc.untitled', [$ui]));
    }

    /**
     * Get the view class.
     *
     * @param $view
     * @param $order
     * @param $ui
     * @return mixed|null|string
     */
    protected function getClass($view, $order, $ui)
    {
        $input = app('request');

        $class = evaluate_key($view, 'class', '', [$ui]);

        if (($input->get('_view') == $view['slug']) or (!$input->get('_view') and $order == 0)) {

            $class .= ' active';

        }

        return $class;
    }

}
 