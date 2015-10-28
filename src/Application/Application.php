<?php namespace Anomaly\Streams\Platform\Application;

use Illuminate\Foundation\Bus\DispatchesJobs;

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

    use DispatchesJobs;

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

        $this->reference = env('DEFAULT_REFERENCE', $this->reference);
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
        app('db')->getSchemaBuilder()->getConnection()->setTablePrefix($this->getReference() . '_');
        app('db')->getSchemaBuilder()->getConnection()->getSchemaGrammar()->setTablePrefix($this->getReference() . '_');
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
     * Get the storage path for the application.
     *
     * @param string $path
     * @return string
     */
    public function getStoragePath($path = '')
    {
        return storage_path('streams/' . $this->getReference()) . ($path ? '/' . $path : $path);
    }

    /**
     * Get the resources path for the application.
     *
     * @param string $path
     * @return string
     */
    public function getResourcesPath($path = '')
    {
        return base_path('resources/' . $this->getReference()) . ($path ? '/' . $path : $path);
    }

    /**
     * Get the public assets path for the application.
     *
     * @param string $path
     * @return string
     */
    public function getAssetsPath($path = '')
    {
        return public_path('assets/' . $this->getReference()) . ($path ? '/' . $path : $path);
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

        return true;
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
