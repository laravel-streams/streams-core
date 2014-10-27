<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableAction;
use Anomaly\Streams\Platform\Ui\Table\TableUtility;
use Illuminate\Foundation\Application;

/**
 * Class BuildTableActionsCommandHandler
 * Builds action data to send to the table view for each row.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableActionsCommandHandler
{
    /**
     * These are not attributes.
     *
     * @var array
     */
    protected $notAttributes = [
        'type',
        'name',
        'title',
        'class',
        'handler',
    ];

    /**
     * The table utility class.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
     */
    protected $utility;

    /**
     * Create a new BuildTableActionsCommandHandler instance.
     *
     * @param TableUtility $utility
     */
    public function __construct(TableUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildTableActionsCommand $command
     * @return array
     */
    public function handle(BuildTableActionsCommand $command)
    {
        $ui = $command->getUi();

        $actions = [];

        foreach ($ui->getActions() as $action) {

            if (is_string($action)) {

                $action = ['type' => $action];

            }

            // Get this before evaluating
            $handler = $this->getHandler($action);

            unset($action['handler']);

            $action = $this->evaluate($action, $ui);

            $defaults = $this->getDefaults($action, $ui);

            $action = array_merge($defaults, $action);

            $title      = $this->getTitle($action, $ui);
            $class      = $this->getClass($action, $ui);
            $attributes = $this->getAttributes($action);
            $value      = $this->getValue($action);

            $action = compact('title', 'class', 'value', 'attributes');

            $action = $this->normalize($action);

            $this->registerHandler($action, $handler, $ui);

            $actions[] = $action;

        }

        return $actions;
    }

    /**
     * Evaluate each array item for closures.
     * Merge in entry data at this point too.
     *
     * @param $action
     * @param $ui
     * @return mixed|null
     */
    protected function evaluate($action, $ui)
    {
        return evaluate($action, [$ui]);
    }

    /**
     * Get default configuration if any.
     * Then run everything back through evaluation.
     *
     * @param $action
     * @param $ui
     * @return array|mixed|null
     */
    protected function getDefaults($action, $ui)
    {
        $defaults = [];

        if (isset($action['type']) and $defaults = $this->utility->getActionDefaults($action['type'])) {

            $defaults = $this->evaluate($defaults, $ui);

        }

        return $defaults;
    }

    /**
     * Get the translated title.
     *
     * @param $action
     * @param $ui
     * @return string
     */
    protected function getTitle($action, $ui)
    {
        return trans(evaluate_key($action, 'title', null, [$ui]));
    }

    /**
     * Get the class.
     *
     * @param $action
     * @param $ui
     * @return mixed|null
     */
    protected function getClass($action, $ui)
    {
        return evaluate_key($action, 'class', 'btn btn-sm btn-default', [$ui]);
    }

    /**
     * Get the attributes less the keys that are
     * defined as NOT attributes.
     *
     * @param $action
     * @return array
     */
    protected function getAttributes($action)
    {
        return array_diff_key($action, array_flip($this->notAttributes));
    }

    /**
     * Get the submit button value.
     *
     * @param $action
     * @return mixed|null
     */
    protected function getValue($action)
    {
        return hashify($action);
    }

    /**
     * Get the action handler.
     * This can be a class path to a handler
     * or a valid closure. Defaults to bitching.
     *
     * @param $action
     * @return callable
     */
    protected function getHandler($action)
    {
        if (!isset($action['handler'])) {

            throw new \Exception("No action handler defined. Please provide a closure or valid class path to your handler [{$action['title']}]");

        }

        return $action['handler'];
    }

    /**
     * Normalize the data. Convert paths to full URLs
     * and make parse the attributes to a string, etc.
     *
     * @param $action
     * @return mixed
     */
    protected function normalize($action)
    {
        if (isset($action['attributes']['url'])) {

            if (!starts_with($action['attributes']['url'], 'http')) {

                $action['attributes']['url'] = url($action['attributes']['url']);

            }

            $action['attributes']['href'] = $action['attributes']['url'];

            unset($action['attributes']['url']);

        }

        if (isset($action['attributes'])) {

            $action['attributes'] = $this->utility->attributes($action['attributes']);

        }

        return $action;
    }

    /**
     * Register the handler to the IoC container.
     *
     * @param $action
     * @param $handler
     * @param $ui
     */
    protected function registerHandler($action, $handler, $ui)
    {
        $abstract = get_class($ui) . '@action-' . $action['value'];

        if ($handler instanceof \Closure) {

            $handler = function () use ($handler) {
                return $handler;
            };

        }

        app()->bind($abstract, $handler);
    }

}
 