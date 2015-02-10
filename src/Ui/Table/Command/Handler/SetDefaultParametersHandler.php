<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\SetDefaultParameters;

/**
 * Class SetDefaultParametersHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetDefaultParametersHandler
{

    /**
     * Set the table model object from the builder's model.
     *
     * @param SetDefaultParameters $command
     */
    public function handle(SetDefaultParameters $command)
    {
        $builder = $command->getBuilder();

        /**
         * Set the default views handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getViews()) {

            $views = str_replace('TableBuilder', 'TableViews', get_class($builder));

            if (class_exists($views)) {
                $builder->setViews($views . '@handle');
            }
        }

        /**
         * Set the default filters handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getFilters()) {

            $filters = str_replace('TableBuilder', 'TableFilters', get_class($builder));

            if (class_exists($filters)) {
                $builder->setFilters($filters . '@handle');
            }
        }

        /**
         * Set the default columns handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getColumns()) {

            $columns = str_replace('TableBuilder', 'TableColumns', get_class($builder));

            if (class_exists($columns)) {
                $builder->setColumns($columns . '@handle');
            }
        }

        /**
         * Set the default buttons handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getButtons()) {

            $buttons = str_replace('TableBuilder', 'TableButtons', get_class($builder));

            if (class_exists($buttons)) {
                $builder->setButtons($buttons . '@handle');
            }
        }

        /**
         * Set the default actions handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getActions()) {

            $actions = str_replace('TableBuilder', 'TableActions', get_class($builder));

            if (class_exists($actions)) {
                $builder->setActions($actions . '@handle');
            }
        }
    }
}
