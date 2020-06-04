<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Platform\Ui\Form\Command\ValidateForm;
use Anomaly\Streams\Platform\Ui\Form\Command\LoadFormValues;
use Anomaly\Streams\Platform\Ui\Form\Command\FlashFormErrors;
use Anomaly\Streams\Platform\Ui\Form\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Form\Workflows\QueryWorkflow;
use Anomaly\Streams\Platform\Ui\Form\Command\FlashFieldValues;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder;

/**
 * Class FormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'async' => false,
        'handler' => null,
        'validator' => null,

        'stream' => null,
        'repository' => null,

        'entry' => null,

        'fields' => [],
        'skips' => [],
        'rules' => [],
        'assets' => [],
        'actions' => [],
        'buttons' => [],
        'options' => [],
        'sections' => [],

        'save' => true,
        'read_only' => false,

        'component' => 'form',

        'form' => Form::class,
        
        'field_builder' => FieldBuilder::class,

        'build_workflow' => BuildWorkflow::class,
        'query_workflow' => QueryWorkflow::class,
    ];

    //---------------------------------------------------------------------
    //-------------------------    Old Shit    ----------------------------
    //---------------------------------------------------------------------

    /**
     * Validate the form.
     *
     * @return $this
     */
    public function validate()
    {
        dispatch_now(new LoadFormValues($this));
        dispatch_now(new ValidateForm($this));

        return $this;
    }

    /**
     * Flash form information to be
     * used in conjunction with redirect
     * type responses (not self handling).
     */
    public function flash()
    {
        dispatch_now(new FlashFormErrors($this));
        dispatch_now(new FlashFieldValues($this));
    }

    /**
     * Save the form.
     */
    public function saveForm()
    {
        dispatch_now(new SaveForm($this));
    }
}
