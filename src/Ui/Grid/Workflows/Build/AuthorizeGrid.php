<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Grid\GridAuthorizer;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class AuthorizeForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeGrid
{

    /**
     * Handle the command.
     *
     * @param GridAuthorizer $authorizer
     * @param GridBuilder $builder
     */
    public function handle(GridAuthorizer $authorizer, GridBuilder $builder)
    {
        $authorizer->authorize($builder);
    }
}
