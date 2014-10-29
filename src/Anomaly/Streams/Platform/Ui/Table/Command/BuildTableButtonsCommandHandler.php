<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUtility;

/**
 * Class BuildTableButtonsCommandHandler
 * Builds button data to send to the table view for each row.
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
     * The table utility class.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
     */
    protected $utility;

    /**
     * Create a new BuildTableButtonsCommandHandler instance.
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
     * @param BuildTableButtonsCommand $command
     * @return array
     */
    public function handle(BuildTableButtonsCommand $command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $buttons = [];

        foreach ($ui->getButtons() as $button) {

            /**
             * If only the type is sent along
             * we default everything like bad asses.
             */
            if (is_string($button)) {

                $button = ['type' => $button];

            }

            // Evaluate everything in the array.
            // All closures are gone now.
            $button = $this->utility->evaluate($button, [$ui, $entry], $entry);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($button, $ui, $entry);

            $button = array_merge($defaults, $button);

            // Build out our required data.
            $title      = $this->getTitle($button);
            $class      = $this->getClass($button);
            $dropdown   = $this->getDropdown($button);
            $attributes = $this->getAttributes($button);

            $button = compact('title', 'class', 'attributes', 'dropdown');

            // Normalize things a bit before proceeding.
            $button = $this->normalize($button);

            $buttons[] = $button;

        }

        return $buttons;
    }

    /**
     * Get default configuration if any.
     * Then run everything back through evaluation.
     *
     * @param $button
     * @param $ui
     * @param $entry
     * @return array|mixed|null
     */
    protected function getDefaults($button, $ui, $entry)
    {
        if (isset($button['type']) and $defaults = $this->utility->getButtonDefaults($button['type'])) {

            return $this->utility->evaluate($defaults, [$ui, $entry], $entry);

        }

        return [];
    }

    /**
     * Get the translated title.
     *
     * @param $button
     * @return string
     */
    protected function getTitle($button)
    {
        return trans(evaluate_key($button, 'title', null));
    }

    /**
     * Get the class.
     *
     * @param $button
     * @return mixed|null
     */
    protected function getClass($button)
    {
        return evaluate_key($button, 'class', 'btn btn-sm btn-default');
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

    /**
     * Get the dropdown items.
     *
     * @param $button
     * @return array
     */
    protected function getDropdown($button)
    {
        $dropdowns = [];

        if (isset($button['dropdown'])) {

            foreach ($button['dropdown'] as $dropdown) {

                $dropdown['title'] = trans($dropdown['title']);

                if (!starts_with($dropdown['url'], 'http')) {

                    $dropdown['url'] = url($dropdown['url']);

                }

                $dropdowns[] = $dropdown;

            }

        }

        return $dropdowns;
    }

    /**
     * Normalize the data. Convert paths to full URLs
     * and make parse the attributes to a string, etc.
     *
     * @param $button
     * @return mixed
     */
    protected function normalize($button)
    {
        /**
         * If a URL is present but not absolute
         * then we need to make it so.
         */
        if (isset($button['attributes']['url'])) {

            if (!starts_with($button['attributes']['url'], 'http')) {

                $button['attributes']['url'] = url($button['attributes']['url']);

            }

            $button['attributes']['href'] = $button['attributes']['url'];

            unset($button['attributes']['url']);

        }

        /**
         * Implode all the attributes left over
         * into an HTML attribute string.
         */
        if (isset($button['attributes'])) {

            $button['attributes'] = $this->utility->attributes($button['attributes']);

        }

        return $button;
    }

}
 