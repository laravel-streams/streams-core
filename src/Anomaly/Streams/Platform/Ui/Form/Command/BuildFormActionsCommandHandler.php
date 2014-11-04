<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;

/**
 * Class BuildFormActionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormActionsCommandHandler
{

    /**
     * These are not attributes and won't
     * make it into the attribute string.
     *
     * @var array
     */
    protected $notAttributes = [
        'title',
        'class',
    ];

    /**
     * The form utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUtility
     */
    protected $utility;

    /**
     * Create a new BuildFormActionsCommandHandler instance.
     *
     * @param FormUtility $utility
     */
    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildFormActionsCommand $command
     * @return array
     */
    public function handle(BuildFormActionsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $actions = [];

        foreach ($ui->getActions() as $action) {

            // Standardize input.
            $action = $this->standardize($action);

            // Evaluate everything in the array.
            // All closures are gone now.
            $action = $this->utility->evaluate($action, [$ui, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($action, $ui, $entry);

            $action = array_merge($defaults, $action);

            // Build out our required data.
            $title      = $this->getTitle($action);
            $class      = $this->getClass($action);
            $attributes = $this->getAttributes($action);

            $action = compact('title', 'class', 'value', 'attributes');

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
     * @return array
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
     * Get default data for the action's type if any.
     *
     * @param array  $action
     * @param Form $ui
     * @param        $entry
     * @return array|mixed|null
     */
    protected function getDefaults(array $action, Form $ui, $entry)
    {
        if (isset($action['type']) and $defaults = $this->utility->getActionDefaults($action['type'])) {

            // Be sure to run the defaults back through evaluate.
            return $this->utility->evaluate($defaults, [$ui, $entry], $entry);
        }

        return [];
    }

    /**
     * Get the translated title.
     *
     * @param array $action
     * @return string
     */
    protected function getTitle(array $action)
    {
        return trans(evaluate_key($action, 'title'));
    }

    /**
     * Get the class.
     *
     * @param array $action
     * @return mixed|null
     */
    protected function getClass(array $action)
    {
        return evaluate_key($action, 'class', 'btn btn-sm btn-success');
    }

    /**
     * Get the url.
     *
     * @param array $action
     * @return string
     */
    protected function getUrl(array $action)
    {
        return url(evaluate_key($action, 'url'));
    }

    /**
     * Get the attributes. This is the entire array
     * less the keys marked as "not attributes".
     *
     * @param array $action
     * @return array
     */
    protected function getAttributes(array $action)
    {
        return array_diff_key($action, array_flip($this->notAttributes));
    }
}
 