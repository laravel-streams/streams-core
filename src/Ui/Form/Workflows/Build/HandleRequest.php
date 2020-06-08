<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class HandleRequest
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HandleRequest
{

    /**
     * Handle the command.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!Request::post()) {
            return;
        }

        dd(__CLASS__);
    }
}
