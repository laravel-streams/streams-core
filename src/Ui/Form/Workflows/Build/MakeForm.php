<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Section\SectionCollection;

/**
 * Class MakeForm
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class MakeForm
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->form instanceof Form) {
            return;
        }

        /**
         * Default attributes.
         */
        $attributes = [

            'stream' => $builder->stream,

            'options' => new Collection(),

            'data' => new Collection(), // Remove
            'values' => new Collection(), // Remove? post()? form->fields->foo->value?
            'errors' => new MessageBag(),
            'fields' => new FieldCollection(),
            'actions' => new ActionCollection(),
            'buttons' => new ButtonCollection(),
            'sections' => new SectionCollection(),
        ];

        /**
         * Default to configured.
         */
        if ($builder->form) {
            $builder->form = App::make($builder->form, compact('attributes'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->form) {
            $builder->form = App::make(Form::class, compact('attributes'));
        }
    }
}
