<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

class StandardizeFilterInputCommandHandler
{

    public function handle(StandardizeFilterInputCommand $command)
    {
        $builder = $command->getBuilder();

        $filters = [];

        foreach ($builder->getFilters() as $key => $filter) {

            /**
             * If the key is numeric and the filter is
             * a string then assume the filter is a field
             * type and that the filter is the field slug.
             */
            if (is_numeric($key) && is_string($filter)) {

                $filter = [
                    'slug'   => $filter,
                    'field'  => $filter,
                    'filter' => 'field',
                ];
            }

            /**
             * If the key is NOT numeric and the filter is a
             * string then use the key as the slug and the
             * filter as the filter.
             */
            if (!is_numeric($key) && is_string($filter)) {

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
            if (is_array($filter) && !isset($filter['slug']) && !is_numeric($key)) {

                $filter['slug'] = $key;
            }

            $filters[] = $filter;
        }

        $builder->setFilters($filters);
    }
}
 