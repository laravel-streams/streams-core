<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

use Anomaly\Streams\Platform\Ui\Form\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Laracasts\Commander\CommanderTrait;

class Field implements FieldInterface
{

    use CommanderTrait;

    protected $form;

    protected $slug;

    protected $type;

    protected $label;

    protected $value;

    protected $rules;

    protected $config;

    protected $include;

    protected $placeholder;

    protected $instructions;

    function __construct(
        $slug,
        $type,
        Form $form,
        $label = null,
        $value = null,
        $include = true,
        $placeholder = null,
        $instructions = null,
        array $rules = [],
        array $config = []
    ) {
        $this->form         = $form;
        $this->slug         = $slug;
        $this->type         = $type;
        $this->label        = $label;
        $this->value        = $value;
        $this->rules        = $rules;
        $this->config       = $config;
        $this->include      = $include;
        $this->placeholder  = $placeholder;
        $this->instructions = $instructions;

        if ($include) {

            $this->form->addInclude($this->slug);
        }

        /**
         * Field is used to determine class resolution
         * here so we use slug instead. The builder
         * expects field though.
         */
        $field = $slug;

        $args = compact('field', 'type', 'label', 'value', 'config', 'placeholder', 'instructions');

        $this->type = $this->execute('Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand', $args);

        $this->type->setPrefix($this->form->getPrefix());

        $this->setFormRules();
    }

    public function viewData(array $arguments = [])
    {
        $input = $this->type->render();

        return compact('input');
    }

    protected function setFormRules()
    {
        $rules = array_merge($this->rules, $this->type->getRules());

        $this->form->putRules($this->slug, implode('|', $rules));
    }

    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setInclude($include)
    {
        $this->include = $include;

        return $this;
    }

    public function getInclude()
    {
        return $this->include;
    }

    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getInstructions()
    {
        return $this->instructions;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
 