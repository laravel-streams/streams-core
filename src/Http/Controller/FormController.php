<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Session\Store;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Cache\Repository;
use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;

/**
 * Class FormController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormController extends PublicController
{

    /**
     * Handle the form.
     *
     * @param  Repository $cache
     * @param  Redirector $redirect
     * @param Store $session
     * @param $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Repository $cache, Redirector $redirect, Store $session, $key)
    {
        Cookie::queue('http_cache_proxy', true, 0.1);

        if (!$parameters = $cache->get('form::' . $key)) {

            $this->messages->error('streams::message.form_expired');

            foreach ($this->request->except('_token') as $key => $value) {
                $session->flash($key, $value);
            }

            return $redirect->back();
        }

        /* @var FormCriteria $criteria */
        $criteria = dispatch_sync(new GetFormCriteria($parameters));

        /* @var FormBuilder $builder */
        $builder = $criteria->build();

        $response = $builder
            ->build()
            ->post()
            ->getFormResponse();

        $builder->flash();

        if ($response && $response->getStatusCode() !== 200) {
            return $response;
        }

        if ($builder->isAjax()) {
            return $builder->getFormResponse();
        }

        if ($builder->hasFormErrors()) {
            return $redirect->back();
        }

        return $response ?: $redirect->back();
    }
}
