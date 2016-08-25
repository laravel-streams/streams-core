<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class MergeFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Multiple\Command
 */
class MergeFields implements SelfHandling
{

    /**
     * The multiple form builder.
     *
     * @var MultipleFormBuilder
     */
    protected $builder;

    /**
     * Create a new MergeFields instance.
     *
     * @param MultipleFormBuilder $builder
     */
    public function __construct(MultipleFormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /* @var FormBuilder $builder */
        foreach ($this->builder->getForms() as $builder) {
            $this->mergeFields($this->builder->getForm(), $builder->getForm());
        }
    }

    /**
     * Merge fields into the form.
     *
     * @param Form $parent
     * @param Form $child
     */
    protected function mergeFields(Form $parent, Form $child)
    {
        foreach ($child->getFields() as $field) {
            $parent->addField($field);
        }
    }
}
