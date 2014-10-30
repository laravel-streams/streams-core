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
     * @param $command
     * @return array
     */
    public function handle($command)
    {
        $views = [];

        $ui = $command->getUi();

        foreach ($ui->getViews() as $order => $view) {

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($view['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $view = $this->utility->evaluate($view, [$ui]);

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
     * Get the view URL.
     *
     * @param $view
     * @param $ui
     * @return string
     */
    protected function getUrl($view, $ui)
    {
        return url(app('request')->path()) . '?' . $ui->getPrefix() . 'view=' . $view['slug'];
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
        return trans(evaluate_key($view, 'title', 'misc.all', [$ui]));
    }

    /**
     * Get the view class.
     *
     * @param $view
     * @param $ui
     * @return mixed|null
     */
    protected function getClass($view, $ui)
    {
        $class = evaluate_key($view, 'class', '', [$ui]);

        return $class;
    }

    /**
     * Get active flag.
     *
     * @param $view
     * @param $order
     * @param $ui
     * @return bool|null
     */
    protected function getActive($view, $order, $ui)
    {
        $input = app('request');

        $executing = $input->get($ui->getPrefix() . 'view');

        if (($executing == $view['slug']) or (!$executing and $order == 0)) {

            return true;

        }

        return null;
    }

}
 