<?php namespace Streams\Platform\Ui\Table\Command;

class BuildTableViewsCommandHandler
{
    /**
     * @param $command
     * @return mixed|null
     */
    public function handle(BuildTableViewsCommand $command)
    {
        $ui = $command->getUi();

        $views = [];

        foreach ($ui->getViews() as $order => $view) {

            $this->addListener($view, $ui);

            $url   = $this->makeUrl($view);
            $title = $this->makeTitle($view, $ui);
            $class = $this->makeClass($view, $order, $ui);

            $views[] = compact('url', 'title', 'class');

        }

        return $views;
    }

    protected function addListener($view, $ui)
    {
        if (isset($view['listener']) and $listener = $view['listener']) {
            if (is_string($listener)) {

                app('events')->listen('Streams.Platform.Ui.Table.*', $listener);

            } elseif ($listener instanceof \Closure) {

                app('events')->listen('Streams.Platform.Ui.Table.Repository.whenHookingViewQuery', $listener);

            }
        }
    }

    /**
     * @param $view
     * @return string
     */
    protected function makeUrl($view)
    {
        return url() . '?view=' . $view['slug'];
    }

    /**
     * @param $view
     * @param $ui
     * @return string
     */
    protected function makeTitle($view, $ui)
    {
        return trans(evaluate_key($view, 'title', 'misc.untitled', [$ui]));
    }

    protected function makeClass($view, $order, $ui)
    {
        $input = app('request');

        $class = evaluate_key($view, 'class', '', [$ui]);

        if (($input->get('view') == $view['slug']) or (!$input->get('view') and $order == 0)) {

            $class .= ' active';

        }

        return $class;
    }
}
 