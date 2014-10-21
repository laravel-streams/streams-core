<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

interface FormRepositoryInterface
{
    /**
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function store();
}
 