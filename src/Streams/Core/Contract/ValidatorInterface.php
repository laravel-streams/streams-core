<?php namespace Streams\Core\Contract;

interface ValidatorInterface
{
    /**
     * Initialize the validator instance.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @return mixed
     */
    public function make(array $data, array $rules, array $messages = []);

    /**
     * Determine if the validation passes.
     *
     * @return boolean
     */
    public function passes();

    /**
     * Return an array of errors.
     *
     * @return array
     */
    public function errors();
}
