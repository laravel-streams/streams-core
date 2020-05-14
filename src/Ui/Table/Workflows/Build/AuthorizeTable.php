<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableAuthorizer;

/**
 * Class AuthorizeTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeTable
{

    /**
     * Handle the command.
     *
     * @param TableAuthorizer $authorizer
     * @param TableBuilder $builder
     */
    public function handle(TableAuthorizer $authorizer, TableBuilder $builder)
    {
        $authorizer->authorize($builder);
    }
}
