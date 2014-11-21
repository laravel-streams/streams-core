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
        $actions = [];

        $table = $command->getTable();

        $presets    = $table->getPresets();
        $expander   = $table->getExpander();
        $evaluator  = $table->getEvaluator();
        $normalizer = $table->getNormalizer();

        /**
         * Loop through and process action configurations.
         */
        foreach ($table->getActions() as $slug => $action) {

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($action['handler']);
            
            // Expand, automate, and evaluate.
            $action = $expander->expand($slug, $action);
            $action = $presets->setActionPresets($action);
            $action = $evaluator->evaluate($action, compact('table'));

            // Skip if disabled.
            if (!array_get($action, 'enabled') === false) {

                continue;
            }

            // All actions are disabled at first.
            $action['disabled'] = 'disabled';

            // Build out our required data.
            $icon  = array_get($action, 'icon');
            $title = array_get($action, 'title');
            $class = array_get($action, 'class');

            $attributes = $this->getAttributes($action, $table);

            $actions[] = $normalizer->normalize(compact('title', 'class', 'icon', 'attributes'));
        }

        return $actions;
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
        $action['name']  = $table->getPrefix() . 'action';
        $action['value'] = $table->getPrefix() . $action['slug'];

        return array_diff_key($action, array_flip($this->notAttributes));
    }
}
 