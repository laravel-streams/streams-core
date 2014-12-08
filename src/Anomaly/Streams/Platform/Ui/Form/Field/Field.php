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

    public function viewData()
    {
        $input = $this->type->render();

        return compact('input');
    }

    public function getSlug()
    {
        return $this->slug;
    }

    protected function setFormRules()
    {
        $rules = array_merge($this->rules, $this->type->getRules());

        $this->form->putRules($this->slug, implode('|', $rules));
    }
}
 