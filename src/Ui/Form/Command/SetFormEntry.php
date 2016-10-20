<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SetFormEntry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetFormEntry
{

    /**
     * The form builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormColumnsCommand instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Set the form model object from the builder's model.
     */
    public function handle()
    {
        $entry      = $this->builder->getEntry();
        $repository = $this->builder->getRepository();

        /*
         * If the entry is null or an ID and the
         * model is an instance of FormModelInterface
         * then use the model to fetch the entry
         * or create a new one.
         */
        if (is_numeric($entry) || $entry === null) {
            if ($repository instanceof FormRepositoryInterface) {
                $this->builder->setFormEntry($repository->findOrNew($entry));

                return;
            }
        }

        /*
         * If the entry is a plain 'ole
         * object  then just use it as is.
         */
        if (is_object($entry)) {
            $this->builder->setFormEntry($entry);

            return;
        }

        /*
         * Whatever it is - just use it.
         */
        $this->builder->setFormEntry($entry);
    }
}
