<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormNormalizer;

class FieldInput
{

    /**
     * The field filler.
     *
     * @var FieldFiller
     */
    protected $filler;

    /**
     * The field guesser.
     *
     * @var FieldGuesser
     */
    protected $guesser;

    /**
     * The field populator.
     *
     * @var FieldPopulator
     */
    protected $populator;

    /**
     * Create a new FieldInput instance.
     *
     * @param FieldFiller     $filler
     * @param FieldGuesser    $guesser
     * @param FieldPopulator  $populator
     */
    public function __construct(
        FieldFiller $filler,
        FieldGuesser $guesser,
        FieldPopulator $populator
    ) {
        $this->filler     = $filler;
        $this->guesser    = $guesser;
        $this->populator  = $populator;
    }

    /**
     * Read the form input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $entry = $builder->getFormEntry();

        /**
         * Resolve & Evaluate
         */
        $fields = resolver($fields, compact('builder', 'entry'));

        $fields = $fields ?: $builder->getFields();

        $fields = evaluate($fields, compact('builder', 'entry'));

        $fields = FormNormalizer::fields($fields);

        if ($fields === []) {
            $fields = ['*'];
        }

        $builder->setFields($fields);

        // -------------------------------------
        $this->filler->fill($builder);
        // -------------------------------------

        $fields = $builder->getFields();

        $fields = FormNormalizer::fields($fields);

        // -------------------------------------
        // -------------- EXTRA ----------------
        // -------------------------------------
        $first = array_shift($fields);

        array_set($first, 'attributes.data-keymap', 'f');

        array_unshift($fields, $first);
        // -------------------------------------
        // ------------ EOF EXTRA --------------
        // -------------------------------------

        $builder->setFields($fields);

        // -------------------------------------
        $this->guesser->guess($builder);
        // -------------------------------------

        $fields = $builder->getFields();

        $fields = parse($fields, compact('entry'));

        $fields = translate($fields);

        $builder->setFields($fields);


        // -------------------------------------
        $this->populator->populate($builder);
        // -------------------------------------
    }
}
