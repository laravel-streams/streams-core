<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Cache\Repository;

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
     * @param            $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Repository $cache, $key)
    {
        /* @var FormBuilder $builder */
        $builder = $cache->get('form::' . $key);

        return $builder
            ->build()
            ->post()
            ->getFormResponse();
    }
}
