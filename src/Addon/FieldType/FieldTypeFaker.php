<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Faker\Generator;

class FieldTypeFaker
{

    /**
     * The parent field type.
     *
     * @var Faker\Generator|null
     */
    protected $faker = null;

    /**
     * The parent field type.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeQuery instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
        $this->faker     = app(Generator::class);
    }

    /**
     * Gets the fake value for the field type
     *
     * @param   mixed  $default  The default
     * @return  mixed
     */
    public function fake($default = null)
    {
        switch ($this->fieldType->getColumnType()) {
            case 'integer': return $this->faker->randomDigitNotNull;
            case 'string': return $this->faker->word;
            default: return $this->faker->randomDigit;
        };
    }

}
