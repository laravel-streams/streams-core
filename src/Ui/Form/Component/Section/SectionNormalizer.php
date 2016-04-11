<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionNormalizer
 *
 * @link          http://fritzandandre.com
 * @author        Brennon Loveless <brennon@fritzandandre.com>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Section
 */
class SectionNormalizer
{
    /**
     * The width of the grid to use when calculating the column width
     *
     * @var int
     */
    protected $gridSize;

    /**
     * Normalize the section input
     *
     * @param FormBuilder $builder
     */
    public function normalize(FormBuilder $builder)
    {
        $sections       = $builder->getSections();
        $this->gridSize = $builder->getOption('grid_size', 24);

        /**
         * If the form builder contains a sections definition then kick off the parser
         */
        if (!empty($sections)) {
            
            foreach ($sections as $sectionIndex => &$section) {
                $this->parseSection($section);
            }

            $builder->setSections($sections);
            return;
        }

        /**
         * If no section was provided then use the fields as one row/one column per field
         */
        $fields = $builder->getFields();

        foreach ($fields as $field) {
            $sections['section']['rows'][] = ['columns' => [$this->getFieldDefinition($this->gridSize, $field['field'])]];
        }

        $builder->setSections($sections);
    }

    /**
     * Take a raw section and make everything normalized
     *
     * @param array $section
     */
    private function parseSection(array &$section)
    {
        /**
         * If a section contains only a fields array
         * wrap those fields one row and one column each
         */
        if (isset($section['fields'])) {

            $section['rows'] = $this->parseSectionFields($section['fields']);

            unset($section['fields']);

            /**
             * Since a section cannot have both fields and rows
             * we will quit here
             */
            return;
        }
        
        if (isset($section['rows'])) {

            foreach ($section['rows'] as $rowIndex => &$row) {
                
                $this->parseSectionRow($row);
                
            }
        }
    }

    /**
     * Convert an array of field names into full column definitions
     *
     * @param array $sectionFields
     * @return array
     */
    private function parseSectionFields(array $sectionFields)
    {
        $newRow = [];

        foreach ($sectionFields as $field) {

            $newRow[] = [
                'columns' => [
                    $this->getFieldDefinition($this->gridSize, $field)
                ]
            ];
        }

        return $newRow;
    }

    private function parseSectionRow(&$sectionRow)
    {
        /**
         * This is just a field name so add the wrapping data
         */
        if (!isset($sectionRow['columns']) && !is_array($sectionRow[0])) {

            $newRow = [];

            if (is_array($sectionRow)) {
                foreach ($sectionRow as $column) {
                    $newRow['columns'][] = $this->getFieldDefinition(($this->gridSize / count($sectionRow)), $column);
                }
            } else {
                $newRow['columns'][] = $this->getFieldDefinition($this->gridSize, $sectionRow);
            }

            $sectionRow = $newRow;
            return;

        }
        
        /**
         * 
         * This is a column definition so append any additional data
         */

        $fields = $sectionRow['columns'];

        foreach ($fields as $fieldIndex => $field) {

            /**
             * If this field is just a string add the additional data around it
             */
            if (is_string($field)) {
                $field = $this->getFieldDefinition(($this->gridSize / count($fields)), $field);
            }

            /**
             * If there is no size then calculate it based on the fields
             * siblings
             */
            if (!isset($field['size'])) {
                $field['size'] = ($this->gridSize / count($fields));
            }

            /**
             * If there is no class then set an empty class
             */
            if (!isset($field['class'])) {
                $field['class'] = '';
            }

            /**
             * If there is no field then there is nothing we can do
             * just remove it
             */
            if (!isset($field['field'])) {
                unset($sectionRow['columns'][$fieldIndex]);

                continue;
            }

            $sectionRow['columns'][$fieldIndex] = $field;
        }
    }

    /**
     * Create the appropriate field definition
     *
     * @param        $size The size of the columns. The grid size should be evenly divisible by this
     * @param        $field The name of the field
     * @param string $class Any additional classes to be applied to the field
     * @return array
     */
    private
    function getFieldDefinition($size, $field, $class = '')
    {
        return [
            'size'  => $size,
            'class' => $class,
            'field' => $field
        ];
    }
}
