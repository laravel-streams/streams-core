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
     * Normalize the section input
     *
     * @param FormBuilder $builder
     */
    public function normalize(FormBuilder $builder)
    {
        $sections = $builder->getSections();

        /**
         * If no section was provided then use the fields as one row/one column per field
         */
        if (empty($sections)) {

            $fields = $builder->getFields();

            foreach ($fields as $field) {
                $sections['section']['rows'][] = ['columns' => [$this->getFieldDefinition(24, $field['field'])]];
            }
        } else {
            /**
             * Second: The array is a minimal array with rows and columns, but no other data
             */

            foreach ($sections as $sectionIndex => $section) {

                foreach ($section['rows'] as $rowIndex => $row) {

                    /**
                     * This is just a field name so add the wrapping data
                     */
                    if (!isset($row['columns']) && !is_array($row[0])) {

                        $newRow = [];
                        
                        if(is_array($row)) {
                            foreach ($row as $column) {
                                $newRow['columns'][] = $this->getFieldDefinition((24 / count($row)), $column);
                            }
                        } else {
                            $newRow['columns'][] = $this->getFieldDefinition(24, $row);
                        }

                        $sections[$sectionIndex]['rows'][$rowIndex] = $newRow;

                    } else {
                        /**
                         * This is a column definition so append any additional data
                         */
                        
                        $fields = $sections[$sectionIndex]['rows'][$rowIndex]['columns'];
                        
                        foreach($fields as $fieldIndex => $field) {

                            /**
                             * If there is no size then calculate it based on the fields
                             * siblings
                             */
                            if(!isset($field['size'])) {
                                $field['size'] = (24 / count($fields));
                            }

                            /**
                             * If there is no class then set an empty class
                             */
                            if(!isset($field['class'])) {
                                $field['class'] = '';
                            }

                            /**
                             * If there is no field then there is nothing we can do
                             * just remove it
                             */
                            if(!isset($field['field'])) {
                                unset($sections[$sectionIndex]['rows'][$rowIndex]['columns'][$fieldIndex]);
                                
                                continue;
                            }
                            
                            $sections[$sectionIndex]['rows'][$rowIndex]['columns'][$fieldIndex] = $field;
                        }
                    }
                }
            }
        }

        $builder->setSections($sections);
    }

    private function getFieldDefinition($size, $field, $class = '')
    {
        return [
            'size'  => $size,
            'class' => $class,
            'field' => $field
        ];
    }
}
