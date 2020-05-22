<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Message\Facades\Messages;

/**
 * Class SetSuccessMessage
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetSuccessMessage
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetSuccessMessage instance.
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

        // If we can't save or there are errors then skip it.
        if ($this->builder->hasFormErrors() || !$this->builder->canSave()) {
            return;
        }

        $mode = $this->builder->mode;

        // False means no message is desired.
        if ($this->builder->getFormOption('success_message') === false) {
            return;
        }

        $entry  = $this->builder->getFormEntry();
        $stream = $this->builder->getFormStream();

        $parameters = [
            'title' => is_object($entry) ? $entry->title : null,
            'name'  => is_object($stream) ? $stream->name : null,
        ];

        // If the name doesn't exist we need to be clever.
        if (str_contains($parameters['name'], '::') && !trans()->has($parameters['name']) && $stream) {
            $parameters['name'] = ucfirst(str_singular(str_replace('_', ' ', $stream->slug)));
        } elseif ($parameters['name']) {
            $parameters['name'] = str_singular(trans($parameters['name']));
        } else {
            $parameters['name'] = trans('streams::entry.name');
        }

        /**
         * If there is no success message and
         * we are not in the control panel
         * then we don't want to force it.
         */
        if ($request->segment(1) !== 'admin' && $this->builder->getFormOption('success_message') === null) {
            return;
        }

        /*
         * Set the default success message.
         */
        if ($this->builder->getFormOption('success_message') === null) {
            $this->builder->setFormOption(
                'success_message',
                trans('streams::message.' . $mode . '_success', $parameters)
            );
        }

        Messages::{$this->builder->getFormOption('success_message_type', 'success')}(
            $this->builder->getFormOption('success_message')
        );
    }
}
