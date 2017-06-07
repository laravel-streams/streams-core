<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Illuminate\Filesystem\Filesystem;

/**
 * Class PutIntoFile
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class PutIntoFile
{

    /**
     * File path
     *
     * @var string
     */
    protected $path;

    /**
     * Search pattern
     *
     * @var string
     */
    protected $pattern;

    /**
     * New text
     *
     * @var string
     */
    protected $text;

    /**
     * Replace flag
     *
     * @var boolean
     */
    protected $replace;

    /**
     * Matches limit
     *
     * @var integer
     */
    protected $limit;

    /**
     * Create an instance of PutIntoFile class
     *
     * @param string  $path    The path
     * @param string  $pattern The pattern
     * @param string  $text    The text
     * @param boolean $replace The replace
     * @param integer $limit   The limit
     */
    public function __construct($path, $pattern, $text, $replace = false, $limit = 1)
    {
        $this->path    = $path;
        $this->text    = $text;
        $this->limit   = $limit;
        $this->pattern = $pattern;
        $this->replace = $replace;
    }

    /**
     * Handle the command
     *
     * @param Filesystem $filesystem The filesystem
     */
    public function handle(Filesystem $filesystem)
    {
        $contents = $filesystem->get($this->path);

        $new_contents = preg_replace(
            $this->pattern,
            ($this->replace) ? $this->text : '$0' . $this->text,
            $contents,
            $this->limit
        );

        return $filesystem->put($this->path, $new_contents);
    }
}
