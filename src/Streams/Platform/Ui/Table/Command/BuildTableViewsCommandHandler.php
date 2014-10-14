<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTableViewsCommandHandler implements CommandInterface
{
    /**
     * @param $command
     * @return mixed|null
     */
    public function handle($command)
    {
        $ui = $command->getUi();

        $views = evaluate($ui->getViews(), [$ui]);

        foreach ($views as &$view) {

            $this->addListender($view, $ui);

            $url   = $this->makeUrl($view);
            $title = $this->makeTitle($view, $ui);
            $class = $this->makeClass($view, $ui);

            $view = compact('url', 'title', 'class');

        }

        return $views;
    }

    protected function addListener($view, $ui)
    {
        $listener = evaluate_key($view, 'listener', null, [$ui]);

        if ($listener) {
            $ui->addListener($listener);
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

    /**
     * @param $view
     * @param $ui
     * @return mixed|null|string
     */
    protected function makeClass($view, $ui)
    {
        $input = app('input');

        $class = evaluate_key($view, 'class', '', [$ui]);

        if ($input->get('view') == $view['slug']) {

            $class .= ' active';

        }

        return $class;
    }
}
 