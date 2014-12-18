<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableBuildListener
{

    /**
     * When the table is building we need to load
     * entries from the provided model.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        $builder = $event->getBuilder();

        $this->loadEntries($builder);
    }

    /**
     * Load table entries.
     *
     * @param TableBuilder $builder
     */
    protected function loadEntries(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $model = $builder->getModel();

        /**
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!class_exists($model)) {
            return;
        }

        $model = app($model);

        /**
         * If the model happens to be an instance of
         * EntryInterface then set the stream on the table.
         */
        if ($model instanceof EntryInterface) {
            $table->setStream($model->getStream());
        }

        /**
         * If the set the model is not an instance of
         * TableModelInterface then they need to load
         * the entries themselves.
         */
        if (!$model instanceof TableModelInterface) {
            return;
        }

        $entries = $table->getEntries();

        foreach ($model->getTableEntries($builder) as $entry) {
            $entries->push($entry);
        }
    }
}
