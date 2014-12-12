<?php namespace Anomaly\Streams\Platform\Application\Command;

class InstallApplicationTablesCommand
{

    protected $name;

    protected $domain;

    protected $reference;

    function __construct($name, $domain, $reference)
    {
        $this->name      = $name;
        $this->domain    = $domain;
        $this->reference = $reference;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
 