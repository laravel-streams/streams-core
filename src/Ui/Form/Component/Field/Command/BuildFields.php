<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildFields.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Command
 */
class BuildFields implements SelfHandling
{
    /**
     * The table builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFields instance.
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
     * @param FieldBuilder $builder
     */
    public function handle(FieldBuilder $builder)
    {
        $builder->build($this->builder);
    }
}
