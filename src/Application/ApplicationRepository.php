<?php namespace Anomaly\Streams\Platform\Application;

/**
 * Class ApplicationRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationRepository
{

    /**
     * The application model.
     *
     * @var ApplicationModel
     */
    protected $model;

    /**
     * Create a new ApplicationRepository instance.
     *
     * @param ApplicationModel $model
     */
    public function __construct(ApplicationModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find an application by domain.
     *
     * @param $domain
     * @return null|ApplicationModel
     */
    public function findByDomain($domain)
    {
        return $this->model
            ->leftJoin('applications_domains', 'applications.id', '=', 'applications_domains.application_id')
            ->where('applications.domain', $domain)
            ->orWhere('applications_domains.domain', $domain)
            ->first();
    }
}
