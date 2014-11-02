<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;
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

            // Standardize input.
            $action = $this->standardize($action);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($action['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $action = $this->utility->evaluate($action, [$ui]);

            // If not enabled then skip it.
            if (!evaluate_key($action, 'enabled', true)) {

                continue;
            }

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($action, $ui);

            $action = array_merge($defaults, $action);

            // Build out our required data.
            $name       = $this->getName($ui);
            $icon       = $this->getIcon($action);
            $title      = $this->getTitle($action);
            $class      = $this->getClass($action);
            $value      = $this->getSlug($action, $ui);
            $attributes = $this->getAttributes($action);

            $action = compact('title', 'class', 'icon', 'value', 'name', 'attributes');

            // Normalize things a bit before proceeding.
            $action = $this->utility->normalize($action);

            $actions[] = $action;
        }

        return $actions;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $action
     */
    protected function standardize($action)
    {
        /**
         * If only the type is sent along
         * we default everything like bad asses.
         */
        if (is_string($action)) {

            $action = ['type' => $action];
        }

        return $action;
    }

    /**
     * Get default configuration if any.
     * Then run everything back through evaluation.
     *
     * @param array   $action
     * @param TableUi $ui
     * @return array|mixed|null
     */
    protected function getDefaults(array $action, TableUi $ui)
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
     * @param array $action
     * @return string
     */
    protected function getTitle(array $action)
    {
        return trans(evaluate_key($action, 'title', null));
    }

    /**
     * Get the icon.
     *
     * @param $action
     * @return null|string
     */
    protected function getIcon($action)
    {
        $icon = evaluate_key($action, 'icon', null);

        if ($icon) {

            return '<i class="' . $icon . '"></i>';
        }

        return null;
    }

    /**
     * Get the class.
     *
     * @param array $action
     * @return mixed|null
     */
    protected function getClass(array $action)
    {
        return evaluate_key($action, 'class', 'btn btn-sm btn-default');
    }

    /**
     * Get the attributes less the keys that are
     * defined as NOT attributes.
     *
     * @param array $action
     * @return array
     */
    protected function getAttributes(array $action)
    {
        return array_diff_key($action, array_flip($this->notAttributes));
    }

    /**
     * Get the action slug.
     *
     * @param array   $action
     * @param TableUi $ui
     * @return string
     */
    protected function getSlug(array $action, TableUi $ui)
    {
        return $ui->getPrefix() . $action['slug'];
    }

    /**
     * Get the name of the submit input.
     *
     * @param TableUi $ui
     * @return string
     */
    protected function getName(TableUi $ui)
    {
        return $ui->getPrefix() . 'action';
    }
}
 