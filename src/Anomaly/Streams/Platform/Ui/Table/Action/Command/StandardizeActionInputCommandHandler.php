<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

class StandardizeActionInputCommandHandler
{

    public function handle(StandardizeActionInputCommand $command)
    {
        $builder = $command->getBuilder();

        $actions = [];

        foreach ($builder->getActions() as $key => $action) {

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

            $actions[] = $action;
        }

        $builder->setActions($actions);
    }
}
 