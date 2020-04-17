<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Message\Facades\Messages;

/**
 * Class SetErrorMessages
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetErrorMessages
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetErrorMessages instance.
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
     * @param Request $request
     */
    public function handle(Request $request)
    {
        if ($this->builder->isAjax()) {
            return;
        }

        $errors = $this->builder->getFormErrors();

        Messages::error($errors->all());

        if ($request->segment(1) == 'admin' && ($stream = $this->builder->getFormStream()) && $stream->isTrashable()) {

            /* @var AssignmentInterface $field */
            foreach ($stream->fields as $field) {
                if ($this->builder->hasFormError($field->getSlug())) {
                    Messages::warning(
                        trans(
                            'streams::validation.unique_trash',
                            [
                                'attribute' => '"' . $field->getName() . '"',
                            ]
                        )
                    );
                }
            }
        }
    }
}
