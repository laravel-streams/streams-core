<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetFormStream
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormStream implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
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

    public function handle()
    {
        $form  = $this->builder->getForm();
        $model = $this->builder->getModel();

        if (is_string($model) && !class_exists($model)) {
            return;
        }

        if (is_string($model)) {
            $model = app($model);
        }

        if ($model instanceof EntryInterface) {
            $form->setStream($model->getStream());
        }
    }
}
