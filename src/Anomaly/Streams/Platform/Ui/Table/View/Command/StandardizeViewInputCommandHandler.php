<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

class StandardizeViewInputCommandHandler
{

    public function handle(StandardizeViewInputCommand $command)
    {
        $builder = $command->getBuilder();

        $views = [];

        foreach ($builder->getViews() as $key => $view) {

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

            $views[] = $view;
        }

        $builder->setViews($views);
    }
}
 