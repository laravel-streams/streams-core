<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class StandardizeInputCommandHandler
{

    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $this->standardizeViewInput($builder);
        $this->standardizeFilterInput($builder);
        $this->standardizeColumnInput($builder);
        $this->standardizeButtonInput($builder);
        $this->standardizeActionInput($builder);
    }

    protected function standardizeViewInput(TableBuilder $builder)
    {
        $views = $builder->getViews();

        foreach ($views as $key => &$view) {

            /**
             * If the key is numeric and the view is
             * a string then treat the string as both the
             * view and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same view which is not likely.
             */
            if (is_numeric($key) and is_string($view)) {

                $view = [
                    'slug' => $view,
                    'view' => $view,
                ];
            }

            /**
             * If the key is NOT numeric and the view is a
             * string then use the key as the slug and the
             * view as the view.
             */
            if (!is_numeric($key) and is_string($view)) {

                $view = [
                    'slug' => $key,
                    'view' => $view,
                ];
            }

            /**
             * If the key is not numeric and the view is an
             * array without a slug then use the key for
             * the slug for the view.
             */
            if (is_array($view) and !isset($view['slug']) and !is_numeric($key)) {

                $view['slug'] = $key;
            }
        }

        $builder->setViews(array_values($views));
    }

    protected function standardizeFilterInput(TableBuilder $builder)
    {
        $filters = $builder->getFilters();

        foreach ($filters as $key => &$filter) {

            /**
             * If the key is numeric and the filter is
             * a string then treat the string as both the
             * filter and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same filter which is not likely.
             */
            if (is_numeric($key) and is_string($filter)) {

                $filter = [
                    'slug'   => $filter,
                    'filter' => $filter,
                ];
            }

            /**
             * If the key is NOT numeric and the filter is a
             * string then use the key as the slug and the
             * filter as the filter.
             */
            if (!is_numeric($key) and is_string($filter)) {

                $filter = [
                    'slug'   => $key,
                    'filter' => $filter,
                ];
            }

            /**
             * If the key is not numeric and the filter is an
             * array without a slug then use the key for
             * the slug for the filter.
             */
            if (is_array($filter) and !isset($filter['slug']) and !is_numeric($key)) {

                $filter['slug'] = $key;
            }
        }

        $builder->setFilters(array_values($filters));
    }

    protected function standardizeColumnInput(TableBuilder $builder)
    {
        $columns = $builder->getColumns();

        foreach ($columns as &$column) {

            /**
             * If the key is numeric and the column is not
             * an array then use the column as the value.
             */
            if (!is_array($column)) {

                $column = [
                    'header' => $column,
                    'value'  => $column,
                ];
            }

            /**
             * If the column header is set but is a string
             * convert it into the header's text.
             */
            if (is_array($column) and isset($column['header']) and is_string($column['header'])) {

                $column['header'] = ['text' => $column['header']];
            }
        }

        $builder->setColumns(array_values($columns));
    }

    protected function standardizeButtonInput(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            /**
             * If the key is numeric and the button
             * is a string then it IS the button.
             */
            if (is_numeric($key) and is_string($button)) {

                $button = [
                    'button' => $button,
                ];
            }

            /**
             * If the key is NOT numeric and the button is
             * a string then the button becomes the text.
             */
            if (!is_numeric($key) and is_string($button)) {

                $button = [
                    'button' => $key,
                    'text'   => $button,
                ];
            }

            /**
             * If the key is a string and the button is an
             * array without a button then use the add the slug.
             */
            if (is_array($button) and !isset($button['button']) and !is_numeric($key)) {

                $button['button'] = $key;
            }

            /**
             * If the button is using an icon configuration
             * then make sure it is an array. An icon slug
             * is the most typical case.
             */
            if (is_array($button) and isset($button['icon']) and is_string($button['icon'])) {

                $button['icon'] = ['icon' => $button['icon']];
            }
        }

        $builder->setButtons(array_values($buttons));
    }

    protected function standardizeActionInput(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {

            /**
             * If the key is numeric and the action is
             * a string then treat the string as both the
             * action and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same action which is not likely.
             */
            if (is_numeric($key) and is_string($action)) {

                $action = [
                    'slug'   => $action,
                    'action' => $action,
                ];
            }

            /**
             * If the slug is a string and the action is a
             * string then use the slug as is and the
             * actions as the action.
             */
            if (!is_numeric($key) and is_string($action)) {

                $action = [
                    'slug'   => $key,
                    'action' => $action,
                ];
            }

            /**
             * If the slug is a string and the action is an
             * array without a slug then add the slug.
             */
            if (is_array($action) and !isset($action['slug']) and !is_numeric($key)) {

                $action['slug'] = $key;
            }
        }

        $builder->setActions(array_values($actions));
    }
}
 