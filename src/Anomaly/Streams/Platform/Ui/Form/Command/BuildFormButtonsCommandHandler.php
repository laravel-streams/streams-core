<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class BuildFormButtonsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormButtonsCommandHandler
{

    /**
     * These are not attributes and won't
     * make it into the attribute string.
     *
     * @var array
     */
    protected $notAttributes = [
        'slug',
        'title',
        'class',
    ];

    /**
     * Handle the command.
     *
     * @param BuildFormButtonsCommand $command
     * @return array
     */
    public function handle(BuildFormButtonsCommand $command)
    {
        $buttons = [];

        $form = $command->getForm();

        $entry      = $form->getEntry();
        $presets    = $form->getPresets();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        /**
         * Loop through and process buttons configurations.
         */
        foreach ($form->getButtons() as $slug => $button) {

            // Expand, automate and evaluate.
            $button = $expander->expand($slug, $button);
            $button = $presets->setButtonPresets($button);
            $button = $evaluator->evaluate($button, compact('form'), $entry);

            // Skip if disabled.
            if (array_get($button, 'enabled') === false) {

                continue;
            }

            // Build out our required data.
            $title = array_get($button, 'title');
            $class = array_get($button, 'class');

            $attributes = $this->getAttributes($button, $form);

            $buttons[] = $normalizer->normalize(compact('title', 'class', 'attributes'));
        }

        return $buttons;
    }

    /**
     * Get the attributes. This is the entire array
     * less the keys marked as "not attributes".
     *
     * @param array $button
     * @return array
     */
    protected function getAttributes(array $button)
    {
        return array_diff_key($button, array_flip($this->notAttributes));
    }
}
 