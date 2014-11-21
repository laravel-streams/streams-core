<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class BuildTableButtonsCommandHandler
 *
 * This class builds button data to send
 * to the table view for each row.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableButtonsCommandHandler
{

    /**
     * These are not attributes.
     *
     * @var array
     */
    protected $notAttributes = [
        'type',
        'title',
        'class',
        'dropdown'
    ];

    /**
     * Handle the command.
     *
     * @param BuildTableButtonsCommand $command
     * @return array
     */
    public function handle(BuildTableButtonsCommand $command)
    {
        $buttons = [];

        $table = $command->getTable();
        $entry = $command->getEntry();

        $presets    = $table->getPresets();
        $expander   = $table->getExpander();
        $evaluator  = $table->getEvaluator();
        $normalizer = $table->getNormalizer();

        /**
         * Loop through and process the button configurations.
         */
        foreach ($table->getButtons() as $slug => $button) {

            // Expand and automate.
            $button = $expander->expand($slug, $button);
            $button = $presets->setButtonPresets($button);
            $button = $evaluator->evaluate($button, compact('table', 'entry'), $entry);

            // Skip if disabled.
            if (array_get($button, 'enabled') === false) {

                continue;
            }

            // Build out our required data.
            $icon     = array_get($button, 'icon');
            $title    = array_get($button, 'title');
            $class    = array_get($button, 'class');
            $dropdown = array_get($button, 'dropdown');

            $attributes = $this->getAttributes($button, $table);

            $buttons[] = $normalizer->normalize(compact('title', 'class', 'attributes', 'icon', 'dropdown'));
        }

        return $buttons;
    }

    /**
     * Get the attributes less the keys that are
     * defined as NOT attributes.
     *
     * @param $button
     * @return array
     */
    protected function getAttributes($button)
    {
        return array_diff_key($button, array_flip($this->notAttributes));
    }
}
 