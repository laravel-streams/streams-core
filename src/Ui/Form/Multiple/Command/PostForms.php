<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class PostForms
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Multiple\Command
 */
class PostForms implements SelfHandling
{

    /**
     * The multiple form builder.
     *
     * @var MultipleFormBuilder
     */
    protected $builder;

    /**
     * Create a new PostForms instance.
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
            $builder->post();
        }
    }
}
