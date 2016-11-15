<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Translation\Translator;

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
     */
    public function handle(MessageBag $messages, Translator $translator)
    {
        // If we can't save or there are errors then skip it.
        if ($this->builder->hasFormErrors() || !$this->builder->canSave()) {
            return;
        }

        // If there is no model and there isn't anything specific to say, skip it.
        if (!$this->builder->getFormEntry() && !$this->builder->getFormOption('success_message')) {
            return;
        }

        $mode = $this->builder->getFormMode();

        // False means no message is desired.
        if ($this->builder->getFormOption('success_message') === false) {
            return;
        }

        $entry  = $this->builder->getFormEntry();
        $stream = $this->builder->getFormStream();

        if (!$entry instanceof EloquentModel) {
            return;
        }

        $parameters = [
            'title' => is_object($entry) ? $entry->getTitle() : null,
            'name'  => is_object($stream) ? $stream->getName() : null,
        ];

        // If the name doesn't exist we need to be clever.
        if (str_contains($parameters['name'], '::') && !$translator->has($parameters['name']) && $stream) {
            $parameters['name'] = ucfirst(str_singular(str_replace('_', ' ', $stream->getSlug())));
        } elseif ($parameters['name']) {
            $parameters['name'] = str_singular(trans($parameters['name']));
        } else {
            $parameters['name'] = trans('streams::entry.name');
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

        $messages->{$this->builder->getFormOption('success_message_type', 'success')}(
            $this->builder->getFormOption('success_message')
        );
    }
}
