<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionRepositoryInterface;

class SectionRepository implements SectionRepositoryInterface
{

    protected $sections = [];

    public function find($section)
    {
        return array_get($this->sections, $section);
    }
}
 