<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUtility;

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

            // Standardize for processing.
            $button = $this->standardize($button);

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
            $button = $this->utility->normalize($button);

            $buttons[] = $button;
        }

        return $buttons;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $button
     * @return array
     */
    protected function standardize($button)
    {
        // If the button is a string set as type.
        if (is_string($button)) {

            $button = ['type' => $button];
        }

        return $button;
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
        if (isset($button['dropdown'])) {

            return $this->getDropdownItems($button['dropdown']);
        }

        return [];
    }

    /**
     * Get the items for a dropdown.
     *
     * @param array $dropdown
     * @return array
     */
    protected function getDropdownItems(array $dropdown)
    {
        $items = [];

        foreach ($dropdown as $item) {

            $item['title'] = trans($item['title']);

            // Normalize this here. It won't be reached
            // in the normalizing done later.
            if (!starts_with($item['url'], 'http')) {

                $item['url'] = url($item['url']);
            }

            $items[] = $item;
        }

        return $items;
    }
}
 