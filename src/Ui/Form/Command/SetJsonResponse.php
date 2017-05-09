<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\ResponseFactory;

/**
 * Class SetJsonResponse
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
        $original = $this->builder->getFormResponse();

        if ($action = $this->builder->getActiveFormAction()) {

            $responder->setFormResponse($this->builder, $action);

            if ($original instanceof RedirectResponse) {
                $data->put('redirect', $original->getTargetUrl());
            }
        }

        $data->put('success', !$this->builder->hasFormErrors());
        $data->put('errors', $this->builder->getFormErrors()->toArray());
        
        if ($original && !$original instanceof RedirectResponse) {
            foreach ($original->getData() as $key => $val) {
                $data->put($key, $val);
            }
        }

        $this->builder->setFormResponse(
            $response = $response->json($data)
        );
    }
}
