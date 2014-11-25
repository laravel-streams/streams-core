<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class HandleFormSubmissionActionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionActionCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleFormSubmissionActionCommand $command
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle(HandleFormSubmissionActionCommand $command)
    {
        $form = $command->getForm();

        $entry      = $form->getEntry();
        $presets    = $form->getPresets();
        $expander   = $form->getExpander();
        $evaluator  = $form->getEvaluator();
        $normalizer = $form->getNormalizer();

        $value = app('request')->get($form->getPrefix() . 'action');

        /**
         * Loop through and look for a matching action.
         */
        foreach ($form->getActions() as $slug => $action) {

            // Expand and automate.
            $action = $expander->expand($slug, $action);
            $action = $presets->setActionPresets($action);

            $action['handler'] = $this->getHandler($action, $form);

            $this->runHandler($action, $form);
        }
    }

    /**
     * Get the handler.
     *
     * @param array $action
     * @param Form  $form
     * @return mixed
     */
    protected function getHandler(array $action, Form $form)
    {
        /**
         * If the handler is a string then auto complete
         * the class path if needed based on the form
         * object being used.
         */
        if (is_string($action['handler'])) {

            $utility = $form->getUtility();

            return $utility->autoComplete('Action\\' . $action['handler'], $form);
        }

        return $action['handler'];
    }

    /**
     * Run the handler.
     *
     * @param array $action
     * @param Form  $form
     */
    protected function runHandler(array $action, Form $form)
    {
        /**
         * If the handler is a string and contains
         * http it is a URL. Automate the response.
         */
        if (is_string($action['handler']) and str_contains($action['handler'], 'http')) {

            $form->setResponse(redirect($action['handler']));
        }

        /**
         * If the handler is a string still it is
         * likely a class path. Call the handler
         * through the container.
         */
        if (is_string($action['handler'])) {

            app()->call($action['handler'], compact('form', 'action'));
        }

        /**
         * If the handler is a closure call it
         * through the container.
         */
        if ($action['handler'] instanceof \Closure) {

            app()->call($action['handler'], compact('form', 'action'));
        }

        /**
         * If the handler is an instance of the interface
         * then authorize and run it's handle method.
         */
        if ($action['handler'] instanceof FormActionInterface) {

            $action['handler']->handle($form);
        }
    }
}
 