<?php namespace Anomaly\Streams\Platform\Http\Command;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class ConfigureRequest
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ConfigureRequest
{

    /**
     * Handle the command.
     *
     * @param Request    $request
     * @param Repository $config
     */
    public function handle(Request $request, Repository $config)
    {
        if ($config->get('streams::system.force_ssl')) {
            $request->server->set('HTTPS', true);
        }
    }
}
