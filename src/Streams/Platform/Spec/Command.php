<?php namespace Streams\Platform\Spec;

class Command
{
    /**
     * @var
     */
    protected $test;

    /**
     * @param $test
     */
    function __construct($test)
    {
        $this->test = $test;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }
}
 