<?php namespace Streams\Platform\Http\Filter;

use Illuminate\Http\Request;

class InstallerFilter
{
    /**
     * Redirect to the installer if the
     * application is not installed.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function filter(Request $request)
    {
        $application = app('streams.application');

        if ($request->segment(1) !== 'installer' and !$application->isInstalled()) {
            return redirect('installer');
        }
    }
}
