<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Support\Facades\Session;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class LoadFormErrors
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadFormErrors
{

    /**
     * Handle the event.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        /* @var \Illuminate\Support\MessageBag $errors */
        if ($errors = Session::get($builder->getOption('prefix') . 'errors')) {
            $builder->setFormErrors($errors);
        }
    }
}
