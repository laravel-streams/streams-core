<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

/**
 * Class SetRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetRepository
{

    /**
     * Handle the command.
     *
     * @param Container $container
     * @param FormBuilder $builder
     */
    public function handle(Container $container, FormBuilder $builder)
    {
        /*
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getRepository()) {

            $model = $builder->getFormModel();
            $form  = $builder->getForm();

            if (!$builder->getRepository() && is_object($model)) {
                $builder->setRepository(
                    $container->make(FormRepository::class, ['form' => $form, 'model' => $model])
                );
            }
        }
    }
}
