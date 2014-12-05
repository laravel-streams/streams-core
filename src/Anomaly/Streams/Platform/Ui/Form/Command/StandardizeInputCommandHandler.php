<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonReader;
use Anomaly\Streams\Platform\Ui\Form\Action\ActionReader;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Anomaly\Streams\Platform\Ui\Form\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class StandardizeInputCommandHandler
{

    protected $actionReader;

    protected $buttonReader;

    function __construct(ActionReader $actionReader, ButtonReader $buttonReader)
    {
        $this->actionReader = $actionReader;
        $this->buttonReader = $buttonReader;
    }

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

            if (isset($section['fields'])) {

                //foreach ($section['fields'] as $slug => $field)

                $fields  = $section['fields'];
                $columns = array_get($section, 'columns', [compact('fields')]);
                $rows    = array_get($section, 'rows', [compact('columns')]);
                $layout  = array_get($section, 'layout', compact('rows'));

                $section['layout'] = $layout;

                unset($section['fields'], $section['columns'], $section['rows']);
            }

            if (isset($section['layout']) and !isset($section['section'])) {

                $section['section'] = 'layout';
            }
        }

        $builder->setSections(array_values($sections));
    }

    protected function standardizeActionInput(FormBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {

            $action = $this->actionReader->convert($key, $action);
        }

        $builder->setActions(array_values($actions));
    }

    protected function standardizeButtonInput(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            $button = $this->buttonReader->convert($key, $button);
        }

        $builder->setButtons(array_values($buttons));
    }
}
 