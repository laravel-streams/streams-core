<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

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
     * Handle the command.
     *
     * @param BuildFormActionsCommand $command
     * @return array
     */
    public function handle(BuildFormActionsCommand $command)
    {
        $form = $command->getForm();

        $entry      = $form->getEntry();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        $actions = [];

        foreach ($form->getActions() as $slug => $action) {

            // Standardize input.
            $action = $expander->expand($slug, $action);

            // Evaluate everything in the array.
            // All closures are gone now.
            $action = $evaluator->evaluate($action, compact('form', 'entry'), $entry);

            // Skip if disabled.
            if (!evaluate_key($action, 'enabled', true)) {

                continue;
            }

            // Get our defaults and merge them in.
            //$defaults = $this->getDefaults($action, $form, $entry);

            //$action = array_merge($defaults, $action);

            // Build out our required data.
            $title      = $this->getTitle($action);
            $class      = $this->getClass($action);
            $attributes = $this->getAttributes($action);

            $action = compact('title', 'class', 'value', 'attributes');

            // Normalize things a bit before proceeding.
            $action = $normalizer->normalize($action);

            $actions[] = $action;
        }

        return $actions;
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
 