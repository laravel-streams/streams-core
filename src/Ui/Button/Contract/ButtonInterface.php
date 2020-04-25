<?php

namespace Anomaly\Streams\Platform\Ui\Button\Contract;

/**
 * Interface ButtonInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface ButtonInterface
{

    /**
     * Set the enabled flag.
     *
     * @param $enabled
     * @return mixed
     */
    public function setEnabled($enabled);

    /**
     * Get the enabled flag.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get the entry.
     *
     * @return mixed|null
     */
    public function getEntry();

    /**
     * Set the table.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry);

    /**
     * Set the text.
     *
     * @param  $text
     * @return mixed
     */
    public function setText($text);

    /**
     * Get the text.
     *
     * @return mixed
     */
    public function getText();

    /**
     * Set the primary flag.
     *
     * @param bool $primary
     */
    public function setPrimary($primary);

    /**
     * Return the primary flag.
     *
     * @return bool
     */
    public function isPrimary();

    /**
     * Set the URL.
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * Get the URL.
     *
     * @return null|string
     */
    public function getUrl();
}
