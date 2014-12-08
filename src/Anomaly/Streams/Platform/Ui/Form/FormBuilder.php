<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;

class FormBuilder
{

    use CommanderTrait;
    use DispatchableTrait;

    protected $handler = 'Anomaly\Streams\Platform\Ui\Form\FormHandler@handle';

    protected $standardizerCommand = 'Anomaly\Streams\Platform\Ui\Form\Command\StandardizeInputCommand';

    protected $buildCommand = 'Anomaly\Streams\Platform\Ui\Form\Command\BuildFormCommand';

    protected $handleCommand = 'Anomaly\Streams\Platform\Ui\Form\Command\HandleFormCommand';

    protected $makeCommand = 'Anomaly\Streams\Platform\Ui\Form\Command\MakeFormCommand';

    protected $model = null;

    protected $entry = null;

    protected $sections = [];

    protected $actions = [];

    protected $buttons = [];

    protected $form;

    function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function build($entry = null)
    {
        if ($entry) {

            $this->entry = $entry;
        }

        $this->execute($this->standardizerCommand, ['builder' => $this]);
        $this->execute($this->buildCommand, ['builder' => $this]);

        if (app('request')->isMethod('post')) {

            $this->execute($this->handleCommand, ['builder' => $this]);
        }
    }

    public function make($entry = null)
    {
        $this->build($entry);

        if ($this->form->getResponse() === null or $this->form->getResponse() === false) {

            $this->execute($this->makeCommand, ['builder' => $this]);
        }
    }

    public function render($entry = null)
    {
        $this->make($entry);

        if ($this->form->getResponse() === null or $this->form->getResponse() === false) {

            $content = $this->form->getContent();

            return view($this->form->getWrapper(), compact('content'));
        }

        return $this->form->getResponse();
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setSections(array $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function setButtons($buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function getButtons()
    {
        return $this->buttons;
    }
}
 