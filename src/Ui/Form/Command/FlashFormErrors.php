<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Session\Store;

/**
 * Class FlashFormErrors
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class FlashFormErrors implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new FlashFormErrors instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the event.
     *
     * @param Store $session
     */
    public function handle(Store $session)
    {
        $session->flash($this->builder->getOption('prefix') . 'errors', $this->builder->getFormErrors());
    }
}
