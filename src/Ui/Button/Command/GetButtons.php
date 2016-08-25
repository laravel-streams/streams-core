<?php namespace Anomaly\Streams\Platform\Ui\Button\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\View\Factory;

/**
 * Class GetButtons
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button\Command
 */
class GetButtons implements SelfHandling
{

    /**
     * The button collection.
     *
     * @var mixed
     */
    protected $buttons;

    /**
     * Create a new GetButtons instance.
     *
     * @param $buttons
     */
    public function __construct($buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * Handle the command.
     *
     * @param Factory $view
     * @return \Illuminate\Contracts\View\View
     */
    public function handle(Factory $view)
    {
        return $view->make('streams::buttons/buttons', ['buttons' => $this->buttons]);
    }
}
