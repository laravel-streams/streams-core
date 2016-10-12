<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\ResponseFactory;

/**
 * Class SetJsonResponse
 *
 * @link   http://anomaly.is/streams-platform
 * @author AnomalyLabs, Inc. <hello@anomaly.is>
 * @author Ryan Thompson <ryan@anomaly.is>
 */
class SetJsonResponse
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetJsonResponse instance.
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
     * @param ResponseFactory $response
     * @param ActionResponder $responder
     */
    public function handle(ResponseFactory $response, ActionResponder $responder)
    {
        $data = new Collection();

        if ($action = $this->builder->getActiveFormAction()) {

            $responder->setFormResponse($this->builder, $action);

            $original = $this->builder->getFormResponse();

            if ($original instanceof RedirectResponse) {
                $data->put('redirect', $original->getTargetUrl());
            }
        }

        $data->put('success', !$this->builder->hasFormErrors());
        $data->put('errors', $this->builder->getFormErrors()->toArray());

        $this->builder->setFormResponse(
            $response->json($data)
        );
    }
}
