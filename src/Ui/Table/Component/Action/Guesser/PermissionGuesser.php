<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class PermissionGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PermissionGuesser
{

    /**
     * Guess the action text.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $actions = $builder->getActions();
        $stream  = $builder->getTableStream();

        if (!$module = app('module.collection')->active()) {
            return;
        }

        $section = app('cp.sections')->active();

        foreach ($actions as &$action) {

            /*
             * Nothing to do if set already.
             */
            if (isset($action['permission'])) {
                continue;
            }

            /*
             * Try and guess the permission.
             */
            if ($stream) {
                $action['permission'] = $module->getNamespace($stream->getSlug() . '.' . $action['slug']);
            } elseif ($section) {
                $action['permission'] = $module->getNamespace($section->getSlug() . '.' . $action['slug']);
            }
        }

        $builder->setActions($actions);
    }
}
