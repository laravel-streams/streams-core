<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class BuildFieldsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Command
 */
class BuildFieldsCommand
{

    /**
     * The table builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFieldsCommand instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the table builder.
     *
     * @return FormBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
