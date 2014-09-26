<?php namespace Streams\Platform\Foundation\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ApplicationModel extends Model
{
    /**
     * Find an application record by domain.
     *
     * @param $domain
     * @return mixed
     */
    public function findByDomain($domain)
    {
        $domain = trim(str_replace(array('http://', 'https://'), '', $domain), '/');

        return DB::table('apps')
            ->join('apps_domains', 'apps.id', '=', 'apps_domains.app_id')
            ->where('apps.domain', $domain)
            ->orWhere('apps_domains.domain', $domain)
            ->first();
    }
}
