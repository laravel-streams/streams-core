<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Translation\Translator;

/**
 * Class SetErrorMessages
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetErrorMessages implements SelfHandling
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
     * @param MessageBag $messages
     */
    public function handle(MessageBag $messages, Translator $translator)
    {
        if ($this->builder->isAjax()) {
            return;
        }

        $errors = $this->builder->getFormErrors();

        $messages->error($errors->all());

        if (($stream = $this->builder->getFormStream()) && $stream->isTrashable()) {

            /* @var AssignmentInterface $assignment */
            foreach ($stream->getUniqueAssignments() as $assignment) {
                if ($this->builder->hasFormError($assignment->getFieldSlug())) {
                    $messages->warning(
                        $translator->trans(
                            'streams::validation.unique_trash',
                            [
                                'attribute' => '"' . $translator->trans($assignment->getFieldName()) . '"'
                            ]
                        )
                    );
                }
            }
        }
    }
}
