<?php namespace Anomaly\Streams\Platform\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;

/**
 * Class ApplicationModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application
 */
class ApplicationModel extends Model
{

    /**
     * No timestamps right now.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model table.
     *
     * @var string
     */
    protected $table = 'applications';

    /**
     * Find an application record by domain.
     *
     * @param  $domain
     * @return mixed
     */
    public function findByDomain($domain)
    {
        $domain = trim(str_replace(array('http://', 'https://'), '', $domain), '/');

        /* @var Builder $schema */
        $schema = app('db')->connection()->getSchemaBuilder();

        $schema->getConnection()->getSchemaGrammar()->setTablePrefix(null);
        $schema->getConnection()->setTablePrefix(null);

        $app = app('db')
            ->table('applications')
            ->leftJoin('applications_domains', 'applications.id', '=', 'applications_domains.application_id')
            ->where('applications.domain', $domain)
            ->orWhere('applications_domains.domain', $domain)
            ->first();

        $schema->getConnection()->getSchemaGrammar()->setTablePrefix($app ? $app->reference . '_' : 'default_');
        $schema->getConnection()->setTablePrefix($app ? $app->reference . '_' : 'default_');

        return $app;
    }
}
