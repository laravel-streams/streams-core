<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

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

        foreach ($table->getButtons() as $slug => $button) {

            // Expand and automate.
            $button = $expander->expand($slug, $button);
            $button = $presets->setButtonPresets($button);

            // Evaluate the entire button.
            $button = $evaluator->evaluate($button, compact('table', 'entry'), $entry);

            // Skip if disabled.
            if (array_get($button, 'enabled') === false) {

                continue;
            }

            // Build out our required data.
            $icon       = $this->getIcon($button, $table);
            $title      = $this->getTitle($button, $table);
            $class      = $this->getClass($button, $table);
            $dropdown   = $this->getDropdown($button, $table);
            $attributes = $this->getAttributes($button, $table);

            $button = compact('title', 'class', 'attributes', 'icon', 'dropdown');

            // Normalize the result.
            $button = $normalizer->normalize($button);

            $buttons[] = $button;
        }

        return $buttons;
    }

    /**
     * Get the translated title.
     *
     * @param array $button
     * @param Table $table
     * @return string
     */
    protected function getTitle(array $button, Table $table)
    {
        return trans(array_get($button, 'title'));
    }

    /**
     * Get the class.
     *
     * @param array $button
     * @param Table $table
     * @return mixed|null
     */
    protected function getClass(array $button, Table $table)
    {
        return array_get($button, 'class', 'btn btn-sm btn-default');
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
        foreach ($dropdown as &$item) {

            // Translate the title. This is not
            // processed like the other values later.
            $item['title'] = trans($item['title']);

            // Normalize this here. It won't be reached
            // in the normalizing done later.
            if (!starts_with($item['url'], 'http')) {

                $item['url'] = url($item['url']);
            }
        }

        return $dropdown;
    }

    /**
     * Get the icon.
     *
     * @param array $button
     * @param Table $table
     * @return null|string
     */
    protected function getIcon(array $button, Table $table)
    {
        $icon = array_get($button, 'icon', null);

        if (!$icon) {

            return null;
        }

        return '<i class="' . $icon . '"></i>';
    }
}
 