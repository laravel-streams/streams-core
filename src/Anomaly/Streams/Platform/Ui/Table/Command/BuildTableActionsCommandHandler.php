<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableActionsCommandHandler
 * Builds action data to send to the table view for each row.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableActionsCommandHandler
{

    /**
     * These are not attributes.
     * Everything else will end up
     * in the attribute string.
     *
     * @var array
     */
    protected $notAttributes = [
        'type',
        'name',
        'title',
        'class',
        'handler',
    ];

    /**
     * Handle the command.
     *
     * @param BuildTableActionsCommand $command
     * @return array
     */
    public function handle(BuildTableActionsCommand $command)
    {
        $table = $command->getTable();

        $actions    = $table->getActions();
        $presets    = $table->getPresets();
        $expander   = $table->getExpander();
        $evaluator  = $table->getEvaluator();
        $normalizer = $table->getNormalizer();

        foreach ($actions as $slug => &$action) {

            // Expand and automate.
            $action = $expander->expand($slug, $action);
            $action = $presets->setActionPresets($action);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($action['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $action = $evaluator->evaluate($action, compact('table'));

            // Skip if disabled.
            if (!array_get($action, 'enabled') === false) {

                unset($actions[$slug]);

                continue;
            }

            // All actions start off as disabled="disabled"
            $action['disabled'] = 'disabled';

            // Build out our required data.
            $name  = $this->getName($action, $table);
            $icon  = $this->getIcon($action, $table);
            $value = $this->getValue($action, $table);
            $title = $this->getTitle($action, $table);
            $class = $this->getClass($action, $table);

            $attributes = $this->getAttributes($action, $table);

            $action = compact('title', 'class', 'icon', 'value', 'name', 'attributes');

            // Normalize the result.
            $action = $normalizer->normalize($action);
        }

        return $actions;
    }

    /**
     * Get the translated title.
     *
     * @param array $action
     * @param Table $table
     * @return string
     */
    protected function getTitle(array $action, Table $table)
    {
        return trans(array_get($action, 'title'));
    }

    /**
     * Get the icon.
     *
     * @param array $action
     * @param Table $table
     * @return null|string
     */
    protected function getIcon(array $action, Table $table)
    {
        $icon = array_get($action, 'icon', null);

        if (!$icon) {

            return null;
        }

        return '<i class="' . $icon . '"></i>';
    }

    /**
     * Get the class.
     *
     * @param array $action
     * @return mixed|null
     */
    protected function getClass(array $action)
    {
        return array_get($action, 'class', 'btn btn-sm btn-default');
    }

    /**
     * Get the action slug.
     *
     * @param array $action
     * @param Table $table
     * @return string
     */
    protected function getValue(array $action, Table $table)
    {
        return $table->getPrefix() . $action['slug'];
    }

    /**
     * Get the name of the submit input.
     *
     * @param array $action
     * @param Table $table
     * @return string
     */
    protected function getName(array $action, Table $table)
    {
        return $table->getPrefix() . 'action';
    }

    /**
     * Get the attributes less the keys that are
     * defined as NOT attributes.
     *
     * @param array $action
     * @param Table $table
     * @return array
     */
    protected function getAttributes(array $action, Table $table)
    {
        return array_diff_key($action, array_flip($this->notAttributes));
    }
}
 