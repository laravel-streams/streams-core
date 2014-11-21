<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

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
        'url',
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
        $actions = [];

        $form = $command->getForm();

        $entry      = $form->getEntry();
        $presets    = $form->getPresets();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        /**
         * Loop through and process actions configurations.
         */
        foreach ($form->getActions() as $slug => $action) {

            // Expand and automate.
            $action = $expander->expand($slug, $action);
            $action = $presets->setActionPresets($action);

            // Evaluate the entire action.
            $action = $evaluator->evaluate($action, compact('form'), $entry);

            // Skip if disabled.
            if (array_get($action, 'enabled') === false) {

                continue;
            }

            // Build out our required data.
            $href       = $this->getHref($action, $form);
            $title      = $this->getTitle($action, $form);
            $class      = $this->getClass($action, $form);
            $attributes = $this->getAttributes($action, $form);

            $action = compact('title', 'class', 'value', 'href', 'attributes');

            // Normalize the result.
            $action = $normalizer->normalize($action);

            $actions[] = $action;
        }

        return $actions;
    }

    /**
     * Get the HREF.
     *
     * @param array $action
     * @param Form  $form
     */
    protected function getHref(array $action, Form $form)
    {
        $url = array_get($action, 'url');

        if (starts_with($url, 'http')) {

            return url($url);
        }

        return $url;
    }

    /**
     * Get the translated title.
     *
     * @param array $action
     * @return string
     */
    protected function getTitle(array $action)
    {
        return trans(array_get($action, 'title'));
    }

    /**
     * Get the class.
     *
     * @param array $action
     * @return mixed|null
     */
    protected function getClass(array $action)
    {
        return array_get($action, 'class', 'btn btn-sm btn-success');
    }

    /**
     * Get the url.
     *
     * @param array $action
     * @return string
     */
    protected function getUrl(array $action)
    {
        return url(array_get($action, 'url'));
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
 