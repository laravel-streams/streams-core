<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\DisabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\InstructionsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\LabelsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\PlaceholdersGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\PrefixesGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\ReadOnlyGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\RequiredGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\TranslatableGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\UniqueGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\WarningsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\NullableGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class FieldGuesser
{

    /**
     * Guess field input.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        LabelsGuesser::guess($builder);
        UniqueGuesser::guess($builder);
        EnabledGuesser::guess($builder);
        WarningsGuesser::guess($builder);
        PrefixesGuesser::guess($builder);
        RequiredGuesser::guess($builder);
        NullableGuesser::guess($builder);
        DisabledGuesser::guess($builder);
        ReadOnlyGuesser::guess($builder);
        TranslatableGuesser::guess($builder);
        InstructionsGuesser::guess($builder);
        PlaceholdersGuesser::guess($builder);
    }
}
