<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;

/**
 * Class PostForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostForm
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new PostForm instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->builder->fire('posting', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_posting');

        /**
         * Multiple form builders do not get
         * validated here.. in fact:
         *
         * @todo: Decouple validation into it's own method like multiple form builders
         */
        if (!$this->builder instanceof MultipleFormBuilder) {
            dispatch_now(new ValidateForm($this->builder));
        }

        dispatch_now(new LoadFormValues($this->builder));
        dispatch_now(new RemoveSkippedFields($this->builder));
        dispatch_now(new HandleForm($this->builder));
        dispatch_now(new SetSuccessMessage($this->builder));
        dispatch_now(new HandleVersioning($this->builder));
        dispatch_now(new SetActionResponse($this->builder));

        if ($this->builder->isAjax()) {
            dispatch_now(new SetJsonResponse($this->builder));
        }

        $this->builder->fire('posted', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_posted');

        event(new FormWasPosted($this->builder));
    }
}
