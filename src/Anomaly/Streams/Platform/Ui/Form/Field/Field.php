<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

use Anomaly\Streams\Platform\Ui\Form\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Laracasts\Commander\CommanderTrait;

/**
 * Class Field
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Field
 */
class Field implements FieldInterface
{

    use CommanderTrait;

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * The field slug.
     *
     * @var
     */
    protected $slug;

    /**
     * The field type.
     *
     * @var mixed
     */
    protected $type;

    /**
     * The field label.
     *
     * @var null
     */
    protected $label;

    /**
     * The field value.
     *
     * @var
     */
    protected $value;

    /**
     * The field rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * The field config.
     *
     * @var array
     */
    protected $config;

    /**
     * The include flag.
     *
     * @var bool
     */
    protected $include;

    /**
     * The field placeholder.
     *
     * @var null
     */
    protected $placeholder;

    /**
     * The field instructions.
     *
     * @var null
     */
    protected $instructions;

    /**
     * Create a new Field instance.
     *
     * @param       $slug
     * @param       $type
     * @param Form  $form
     * @param null  $label
     * @param null  $value
     * @param bool  $include
     * @param null  $placeholder
     * @param null  $instructions
     * @param array $rules
     * @param array $config
     */
    public function __construct(
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

        /**
         * If the form has been posted then use the
         * value from the request instead of whatever
         * was passed into the parameters.
         */
        if (app('request')->isMethod('post')) {
            $this->value = $value = app('request')->get($this->form->getPrefix() . $slug);
        }

        /**
         * Build a field type just like we would any 'ol time.
         * Just pass along our provided parameters.
         */
        $args = compact('field', 'type', 'label', 'value', 'config', 'placeholder', 'instructions');

        $this->type = $this->execute('Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand', $args);

        $this->type->setPrefix($this->form->getPrefix());

        $this->setFormRules();
    }

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $input = $this->type->render();

        return compact('input');
    }

    /**
     * Set form rules.
     */
    protected function setFormRules()
    {
        $rules = array_merge($this->rules, $this->type->getRules());

        $this->form->putRules($this->slug, implode('|', $rules));
    }

    /**
     * Set the config.
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get the form.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set the include.
     *
     * @param $include
     * @return $this
     */
    public function setInclude($include)
    {
        $this->include = $include;

        return $this;
    }

    /**
     * Return the include flag.
     *
     * @return bool
     */
    public function isInclude()
    {
        return $this->include;
    }

    /**
     * Set the instructions.
     *
     * @param $instructions
     * @return $this
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get the instructions.
     *
     * @return null
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set the label.
     *
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     *
     * @return null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the placeholder.
     *
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder.
     *
     * @return null
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the rules.
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get the rules.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set the slug.
     *
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the type.
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value.
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
