<?php namespace Anomaly\Streams\Platform\Application;

/**
 * Class Application
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application
 */
class Application
{

    /**
     * Keep installed status around.
     *
     * @var bool
     */
    protected $installed = null;

    /**
     * The application reference.
     *
     * @var string
     */
    protected $reference = 'default';

    /**
     * The application repository.
     *
     * @var ApplicationRepository
     */
    protected $applications;

    /**
     * Create a new Application instance.
     *
     * @param ApplicationRepository $model
     */
    public function __construct(ApplicationRepository $applications)
    {
        $this->applications = $applications;
    }

    /**
     * Setup the application.
     */
    public function setup()
    {
        $this->setTablePrefix();
    }

    /**
     * Set the database table prefix going forward.
     * We really don't need a core table from here on out.
     */
    public function setTablePrefix()
    {
        app('db')->getSchemaBuilder()->getConnection()->setTablePrefix($this->tablePrefix());
        app('db')->getSchemaBuilder()->getConnection()->getSchemaGrammar()->setTablePrefix($this->tablePrefix());
    }

    /**
     * Locate the app by request or passed
     * variable and set the application reference.
     *
     * @return bool
     */
    public function locate()
    {
        if (app('db')->getSchemaBuilder()->hasTable('applications')) {

            if ($app = $this->applications->findByDomain(
                trim(str_replace(array('http://', 'https://'), '', app('request')->root()), '/')
            )
            ) {

                $this->installed = true;
                $this->reference = $app->reference;

                return true;
            }

            return false;
        }

        $this->reference = 'default';

        return true;
    }

    /**
     * Set the reference.
     *
     * @param $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get the reference.
     *
     * @return null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Return the app reference.
     *
     * @return string
     */
    public function tablePrefix()
    {
        if (is_null($this->reference)) {
            $this->locate();
        }

        return $this->reference . '_';
    }

    /**
     * Is the application installed?
     *
     * @return bool
     */
    public function isInstalled()
    {
        if (is_null($this->installed)) {
            $this->installed = file_exists(base_path('.env'));
        }

        return $this->installed;
    }
}
