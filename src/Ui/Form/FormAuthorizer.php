<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Authorizer;

/**
 * Class FormAuthorizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormAuthorizer
{

    /**
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new FormAuthorizer instance.
     *
     * @param ModuleCollection $modules
     * @param Authorizer       $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Authorize the table.
     *
     * @param FormBuilder $builder
     */
    public function authorize(FormBuilder $builder)
    {
        // Try the option first.
        $permission = $builder->getFormOption('permission');

        if ($permission === false) {
            return;
        }

        if (!env('INSTALLED')) {
            return;
        }

        if ($permission && !$this->authorizer->authorizeAny((array)$permission)) {
            abort(403);
        }
    }
}
