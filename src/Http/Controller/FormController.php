<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Cache\Repository;
use Illuminate\Routing\Redirector;

/**
 * Class FormController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Controller
 */
class FormController extends PublicController
{

    /**
     * Handle the form.
     *
     * @param Repository $cache
     * @param Redirector $redirect
     * @param            $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Repository $cache, Redirector $redirect, $key)
    {
        $parameters = $cache->get('form::' . $key);

        $criteria = $this->dispatch(new GetFormCriteria(array_get($parameters, 'builder'), $parameters));

        /* @var FormBuilder $builder */
        $builder = $criteria->builder();

        $response = $builder
            ->build()
            ->post()
            ->getFormResponse();

        if ($builder->hasFormErrors()) {
            return $redirect->back();
        }

        return $response;
    }
}
