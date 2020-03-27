<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormAuthorizer;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class AuthorizeForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeForm
{

    /**
     * Handle the command.
     *
     * @param FormAuthorizer $authorizer
     * @param FormBuilder $builder
     */
    public function handle(FormAuthorizer $authorizer, FormBuilder $builder)
    {
        $authorizer->authorize($builder);
    }
}
