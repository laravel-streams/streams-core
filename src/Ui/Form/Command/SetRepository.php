<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\EntryFormRepository;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentFormRepository;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;

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
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetRepository instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Container $container
     */
    public function handle(Container $container)
    {
        /*
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getRepository()) {

            $entry = $this->builder->getEntry();
            $form  = $this->builder->getForm();

            if (!$this->builder->getRepository() && $entry instanceof Model) {
                $this->builder->setRepository(
                    $container->make(FormRepository::class, ['form' => $form, 'model' => $entry])
                );
            }
        }
    }
}
