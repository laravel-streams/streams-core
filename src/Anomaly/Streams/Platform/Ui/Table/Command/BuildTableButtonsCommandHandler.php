<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUtility;
use Anomaly\Streams\Platform\Contract\ArrayableInterface;

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

            if (is_string($button)) {

                $button = ['type' => $button];

            }

            $button = $this->evaluate($button, $ui, $entry);

            $defaults = $this->getDefaults($button, $ui, $entry);

            $button = array_merge($defaults, $button);

            $title      = $this->getTitle($button, $ui, $entry);
            $class      = $this->getClass($button, $ui, $entry);
            $attributes = $this->getAttributes($button);
            $dropdown   = $this->getDropdown($button);

            $button = compact('title', 'class', 'attributes', 'dropdown');

            $button = $this->normalize($button);

            $buttons[] = $button;

        }

        return $buttons;
    }

    /**
     * Evaluate each array item for closures.
     * Merge in entry data at this point too.
     *
     * @param $button
     * @param $ui
     * @param $entry
     * @return mixed|null
     */
    protected function evaluate($button, $ui, $entry)
    {
        $button = evaluate($button, [$ui, $entry]);

        foreach ($button as &$value) {

            if (is_string($value) and str_contains($value, '{')) {

                if ($entry instanceof ArrayableInterface) {

                    $value = merge($value, $entry->toArray());

                } else {

                    $value = merge($value, (array)$entry);

                }

            }

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

            return $this->evaluate($defaults, $ui, $entry);

        }

        return [];
    }

    /**
     * Get the translated title.
     *
     * @param $button
     * @param $ui
     * @param $entry
     * @return string
     */
    protected function getTitle($button, $ui, $entry)
    {
        return trans(evaluate_key($button, 'title', null, [$ui, $entry]));
    }

    /**
     * Get the class.
     *
     * @param $button
     * @param $ui
     * @param $entry
     * @return mixed|null
     */
    protected function getClass($button, $ui, $entry)
    {
        return evaluate_key($button, 'class', 'btn btn-sm btn-default', [$ui, $entry]);
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
        if (isset($button['attributes']['url'])) {

            if (!starts_with($button['attributes']['url'], 'http')) {

                $button['attributes']['url'] = url($button['attributes']['url']);

            }

            $button['attributes']['href'] = $button['attributes']['url'];

            unset($button['attributes']['url']);

        }

        if (isset($button['attributes'])) {

            $button['attributes'] = $this->utility->attributes($button['attributes']);

        }

        return $button;
    }

}
 