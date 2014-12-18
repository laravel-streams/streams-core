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
     * The application reference.
     *
     * @var null
     */
    protected $reference = 'default';

    /**
     * Keep installed status around.
     *
     * @var null
     */
    protected $installed = null;

    /**
     * The application model.
     *
     * @var ApplicationModel
     */
    protected $model;

    /**
     * Create a new Application instance
     */
    public function __construct(ApplicationModel $model = null)
    {
        $this->model = $model;
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
     * Locate the app by request or passed variable and set the application reference.
     *
     * @return bool
     */
    public function locate($domain = null)
    {
        if (app('db')->getSchemaBuilder()->hasTable('applications')) {
            if (!$domain) {
                $domain = app('request')->root();
            }

            if ($app = $this->model->findByDomain($domain)) {
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
        if (!$this->reference) {
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
        $config = base_path('config/distribution.php');

        return file_exists($config);
    }
}
