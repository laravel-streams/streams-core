<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewDefaults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewDefaults
{

    /**
     * Default table views.
     *
     * @param TableBuilder $builder
     */
    public function defaults(TableBuilder $builder)
    {
        if (!$stream = $builder->getTableStream()) {
            return;
        }

        if ($stream->isTrashable() && !$builder->getViews()) {
            $builder->setViews(
                [
                    'all',
                    'trash'
                ]
            );
        }
    }
}
