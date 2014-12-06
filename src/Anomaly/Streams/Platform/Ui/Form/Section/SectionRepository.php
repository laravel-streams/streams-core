<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionRepositoryInterface;

class SectionRepository implements SectionRepositoryInterface
{

    protected $sections = [
        'fields' => [
            'section' => 'Anomaly\Streams\Platform\Ui\Form\Section\Type\FieldsSection',
        ],
        'tabbed' => [
            'section' => 'Anomaly\Streams\Platform\Ui\Form\Section\Type\TabbedSection',
        ]
    ];

    public function find($section)
    {
        return array_get($this->sections, $section);
    }
}
 