<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Tree\TreeAuthorizer;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class AuthorizeForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeTree
{

    /**
     * Handle the command.
     *
     * @param TreeAuthorizer $authorizer
     * @param TreeBuilder $builder
     */
    public function handle(TreeAuthorizer $authorizer, TreeBuilder $builder)
    {
        $authorizer->authorize($builder);
    }
}
