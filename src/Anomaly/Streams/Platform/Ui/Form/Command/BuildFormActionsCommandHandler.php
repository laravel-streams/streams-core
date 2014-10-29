<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormUi;
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

            /**
             * If only the type is sent along
             * we default everything like bad asses.
             */
            if (is_string($action)) {

                $action = ['type' => $action];

            }

            // Evaluate everything in the array.
            // All closures are gone now.
            $action = $this->evaluate($action, $ui, $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($action, $ui, $entry);

            $action = array_merge($defaults, $action);

            // Build out our required data.
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
     * Evaluate closures in the entire configuration array.
     * Merge in entry data at this point as well.
     *
     * @param        $action
     * @param FormUi $ui
     * @param        $entry
     * @return mixed|null
     */
    protected function evaluate($action, FormUi $ui, $entry)
    {
        $action = evaluate($action, [$ui, $ui->getEntry()]);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($action as &$value) {

            if (is_string($value) and str_contains($value, '{')) {

                if ($entry instanceof EntryInterface) {

                    $value = merge($value, $entry->toArray());

                }

            }

        }

        return $action;
    }

    /**
     * Get default data for the action's type if any.
     *
     * @param $action
     * @param $ui
     * @param $entry
     * @return array|mixed|null
     */
    protected function getDefaults($action, $ui, $entry)
    {
        $defaults = [];

        if (isset($action['type']) and $defaults = $this->utility->getActionDefaults($action['type'])) {

            // Be sure to run the defaults back through evaluate.
            $defaults = $this->evaluate($defaults, $ui, $entry);

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
        return trans(evaluate_key($action, 'title'));
    }

    /**
     * Get the class.
     *
     * @param $action
     * @return mixed|null
     */
    protected function getClass($action)
    {
        return evaluate_key($action, 'class', 'btn btn-sm btn-success');
    }

    /**
     * Get the url.
     *
     * @param $action
     * @return string
     */
    protected function getUrl($action)
    {
        return url(evaluate_key($action, 'url'));
    }

    /**
     * Get the attributes. This is the entire array
     * less the keys marked as "not attributes".
     *
     * @param $action
     * @return array
     */
    protected function getAttributes($action)
    {
        return array_diff_key($action, array_flip($this->notAttributes));
    }

    /**
     * Normalize the resulting data and clean things up
     * before sending it back for the view.
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
 