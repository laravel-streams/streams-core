<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormCriteria;
use Anomaly\Streams\Platform\Ui\Form\FormFactory;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetFormCriteria
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class GetFormCriteria implements SelfHandling
{

    /**
     * The builder parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create a new GetFormCriteria instance.
     *
     * @param array $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Handle the command.
     *
     * @param FormFactory $factory
     * @return FormCriteria
     */
    public function handle(FormFactory $factory)
    {
        if (is_string($this->parameters)) {
            $this->parameters = [
                'builder' => $this->parameters
            ];
        }

        return $factory->make($this->parameters);
    }
}
