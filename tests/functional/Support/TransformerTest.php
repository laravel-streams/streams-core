<?php namespace Streams\Platform\Support;

class TransformerTest extends \PHPUnit_Framework_TestCase
{
    protected static $transformer;

    public static function setUpBeforeClass()
    {
        self::$transformer = new Transformer();
    }

    public function testItCanTransformToHandler()
    {
        //$class = new Command
    }
}
 