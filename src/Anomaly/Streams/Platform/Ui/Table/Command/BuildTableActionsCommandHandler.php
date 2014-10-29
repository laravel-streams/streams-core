<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUtility;

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
     * Everything else will end up
     * in the attribute string.
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

            /**
             * If only the type is sent along
             * we default everything like bad asses.
             */
            if (is_string($action)) {

                $action = ['type' => $action];

            }

            unset($action['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $action = $this->utility->evaluate($action, [$ui]);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($action, $ui);

            $action = array_merge($defaults, $action);

            // Build out our required data.
            $value      = $this->getSlug($action);
            $title      = $this->getTitle($action);
            $class      = $this->getClass($action);
            $attributes = $this->getAttributes($action);

            $action = compact('title', 'class', 'value', 'attributes');

            // Normalize things a bit before proceeding.
            $action = $this->normalize($action);

            $actions[] = $action;

        }

        return $actions;
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

            $defaults = $this->utility->evaluate($defaults, [$ui]);

        }

        return $defaults;
    }

    /**
     * Get the translated title.
     *
     * @param $action
     * @return string
     */
    protected function getTitle($action)
    {
        return trans(evaluate_key($action, 'title', null));
    }

    /**
     * Get the class.
     *
     * @param $action
     * @return mixed|null
     */
    protected function getClass($action)
    {
        return evaluate_key($action, 'class', 'btn btn-sm btn-default');
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
     * Get the action slug.
     *
     * @param $action
     * @return mixed|null
     */
    protected function getSlug($action)
    {
        return evaluate_key($action, 'slug');
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
        /**
         * If a URL is present but not absolute
         * then we need to make it so.
         */
        if (isset($action['attributes']['url'])) {

            if (!starts_with($action['attributes']['url'], 'http')) {

                $action['attributes']['url'] = url($action['attributes']['url']);

            }

            $action['attributes']['href'] = $action['attributes']['url'];

            unset($action['attributes']['url']);

        }

        /**
         * Implode all the attributes left over
         * into an HTML attribute string.
         */
        if (isset($action['attributes'])) {

            $action['attributes'] = $this->utility->attributes($action['attributes']);

        }

        return $action;
    }

}
 