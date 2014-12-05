<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Anomaly\Streams\Platform\Ui\Form\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class StandardizeInputCommandHandler
{

    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $this->standardizeModelInput($builder);
        $this->standardizeSectionInput($builder);
        $this->standardizeActionInput($builder);
        $this->standardizeButtonInput($builder);
    }

    protected function standardizeModelInput(FormBuilder $builder)
    {
        $table = $builder->getForm();
        $class = $builder->getModel();

        $model = app($class);

        /**
         * If the model can extract a Stream then
         * set it on the table at this time so we
         * can use it later if we need.
         */
        if ($model instanceof EntryInterface) {

            $table->setStream($model->getStream());
        }

        if (!$model instanceof FormModelInterface) {

            throw new IncompatibleModelException("[$class] must implement Anomaly\\Streams\\Platform\\Ui\\Form\\Contract\\FormModelInterface");
        }

        $builder->setModel($model);
    }

    protected function standardizeSectionInput(FormBuilder $builder)
    {
        $sections = $builder->getSections();

        foreach ($sections as $key => &$section) {

            if (!isset($section['layout'])) {

                $fields  = array_get($section, 'fields', []);
                $columns = array_get($section, 'columns', [compact('fields')]);
                $rows    = array_get($section, 'rows', [compact('columns')]);
                $layout  = array_get($section, 'layout', compact('rows'));

                $section['layout'] = $layout;

                unset($section['fields'], $section['columns'], $section['rows']);
            }
        }

        $builder->setSections(array_values($sections));
    }

    protected function standardizeActionInput(FormBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {

            /**
             * If the key is numeric and the action is
             * a string then treat the string as both the
             * action and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same action which is not likely.
             */
            if (is_numeric($key) and is_string($action)) {

                $action = [
                    'action' => $action,
                ];
            }

            /**
             * If the key is not numeric and the action is an
             * array without an action then use the key for
             * the action.
             */
            if (is_array($action) and !isset($action['action']) and !is_numeric($key)) {

                $action['action'] = $key;
            }

            /**
             * If the action is an array and action is not set
             * but the slug is.. use the slug as the action.
             */
            if (is_array($action) and !isset($action['action']) and isset($action['slug'])) {

                $action['action'] = $action['slug'];
            }
        }

        $builder->setActions(array_values($actions));
    }

    protected function standardizeButtonInput(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            /**
             * If the key is numeric and the button
             * is a string then it IS the button.
             */
            if (is_numeric($key) and is_string($button)) {

                $button = [
                    'button' => $button,
                ];
            }

            /**
             * If the key is NOT numeric and the button is
             * a string then the button becomes the text.
             */
            if (!is_numeric($key) and is_string($button)) {

                $button = [
                    'button' => $key,
                    'text'   => $button,
                ];
            }

            /**
             * If the key is a string and the button is an
             * array without a button then use the add the slug.
             */
            if (is_array($button) and !isset($button['button']) and !is_numeric($key)) {

                $button['button'] = $key;
            }

            /**
             * If the button is using an icon configuration
             * then make sure it is an array. An icon slug
             * is the most typical case.
             */
            if (is_array($button) and isset($button['icon']) and is_string($button['icon'])) {

                $button['icon'] = ['icon' => $button['icon']];
            }
        }

        $builder->setButtons(array_values($buttons));
    }
}
 