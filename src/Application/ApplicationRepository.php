<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Model\EloquentRepository;

/**
 * Class ApplicationRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationRepository extends EloquentRepository
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
        $domain = trim(str_replace(['http://', 'https://'], '', $domain), '/');

        return $this->model
            ->leftJoin('applications_domains', 'applications.id', '=', 'applications_domains.application_id')
            ->where('applications.domain', $domain)
            ->orWhere('applications_domains.domain', $domain)
            ->first();
    }
}
