<?php namespace Streams\Platform\Foundation;

interface ApplicationModelInterface
{
    /**
     * Find an application by it's domain.
     *
     * @param $domain
     * @return mixed
     */
    public function findByDomain($domain);
}
