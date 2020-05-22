<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Support\MessageBag;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Ui\Form\Command\ValidateForm;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Ui\Form\Command\LoadFormValues;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Command\FlashFormErrors;
use Anomaly\Streams\Platform\Ui\Form\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Form\Command\FlashFieldValues;
use Anomaly\Streams\Platform\Version\Contract\VersionInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection;

/**
 * Class FormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormBuilder
{

    use Properties;
    use FiresCallbacks;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes([
            'async' => false,
            'handler' => null,
            'validator' => null,
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

            'form' => Form::class,
        ]);

        $this->buildProperties();

        $this->fill($attributes);
    }

    /**
     * Build and return the form instance.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->built === true) {
            return $this;
        }

        $this->fire('ready', ['builder' => $this]);

        (new BuildWorkflow)->process(['builder' => $this]);

        $this->fire('built', ['builder' => $this]);

        $this->built = true;

        return $this;
    }

    /**
     * Render the form.
     *
     * @return View
     */
    public function render()
    {
        $this->build();

        return $this->form->render();
    }

    /**
     * Return the form response.
     * 
     * @return Response
     */
    public function response()
    {
        if (false/* is async request */) {
            return $this->json();
        }

        return Response::view('streams::default', ['content' => $this->render()]);
    }

    /**
     * Return a JSON response.
     *
     * @return JsonResponse
     */
    public function json()
    {
        $this->build();

        return Response::json($this->form->toJson());
    }

    /**
     * Get a request value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function request($key, $default = null)
    {
        return Request::get($this->form->options->get('prefix') . $key, $default);
    }

    /**
     * Get a post value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return Request::post($this->form->options->get('prefix') . $key, $default);
    }

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
