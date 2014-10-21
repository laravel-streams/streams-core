<?php namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Support\Generator;
use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryGenerator extends Generator
{
    /**
     * Relational fields on the entry.
     *
     * @var
     */
    protected $relationFields;

    /**
     * Return the application reference path.
     *
     * @return string
     */
    public function appRefPath()
    {
        return 'storage/models/streams/' . app('streams.application')->getReference();
    }

    /**
     * Compile an entry model.
     *
     * @param StreamModel $stream
     * @return bool
     */
    public function compileEntryModel(StreamModel $stream)
    {
        $stream->load('assignments.field');

        if (!empty($stream->slug) and !empty($stream->namespace)) {

            $appRefPath = $this->appRefPath();

            $namespace = Str::studly($stream->namespace);

            // Create the app ref folder
            if (!is_dir(base_path("{$appRefPath}"))) {
                mkdir(base_path("{$appRefPath}"), 0777, true);
            }

            // Create the namespace folder
            if (!is_dir(base_path("{$appRefPath}/{$namespace}"))) {
                mkdir(base_path("{$appRefPath}/{$namespace}"), 0777, true);
            }

            $className = Str::studly($stream->namespace . '_' . $stream->slug) . 'EntryModel';

            $this->make(
                base_path("{$appRefPath}/{$namespace}/{$className}.php"),
                [
                    '{className}'       => $className,
                    '{namespacePrefix}' => studly_case($namespace),
                    '{table}'           => "'" . $stream->prefix . $stream->slug . "'",
                    '{rules}'           => $this->compileStreamValidation($stream),
                    '{stream}'          => $this->compileStreamData($stream),
                    '{relations}'       => $this->compileRelations($stream),
                    '{relationFields}'  => $this->compileRelationFieldsData($stream),
                ],
                $update = true
            );


            return true;
        }

        return false;
    }

    /**
     * Compile Stream data
     *
     * @param StreamModel $stream
     * @return string
     */
    protected function compileStreamData(StreamModel $stream)
    {
        // Stream attributes array
        $string = '[';

        foreach ($stream->getAttributes() as $key => $value) {

            $value = $this->adjustValue($value, in_array($key, ['stream_name', 'about']));

            $string .= "\n{$this->s(8)}'{$key}' => {$value},";

        }

        // Assignments array
        $string .= "\n{$this->s(8)}'assignments' => [";

        foreach ($stream->assignments as $assignment) {

            // Assignment attributes array
            $string .= "\n{$this->s(12)}[";

            foreach ($assignment->getAttributes() as $key => $value) {

                $value = $this->adjustValue($value, in_array($key, ['instructions']));

                $string .= "\n{$this->s(16)}'{$key}' => {$value},";
            }

            // Field attributes array
            $string .= "\n{$this->s(16)}'field' => [";

            foreach ($assignment->field->getAttributes() as $key => $value) {

                $value = $this->adjustValue($value, in_array($key, ['field_name']));

                $string .= "\n{$this->s(20)}'{$key}' => {$value},";

            }

            // End field attributes array
            $string .= "\n{$this->s(16)}],";

            // End assignment attributes array
            $string .= "\n{$this->s(12)}],";
        }

        // End assignments array
        $string .= "\n{$this->s(8)}],";

        // End stream attributes array
        $string .= "\n{$this->s(4)}]";

        return $string;
    }

    /**
     * Compile Stream rules
     *
     * @param StreamModel $stream
     * @return string
     */
    protected function compileStreamValidation(StreamModel $stream)
    {
        // Rules array
        $string = '[';

        foreach ($stream->assignments as $assignment) {

            $rules = [];

            if ($assignment->field->rules) {
                foreach ($assignment->field->rules as $rule) {
                    $rules[] = $rule;
                }
            }

            if ($assignment->is_required) {
                $rules[] = 'required';
            }

            if (is_array($rules)) {
                $rules = implode('|', array_filter($rules));

                $string .= "\n{$this->s(8)}'{$assignment->field->slug}' => '{$rules}',";
            }

        }

        // End rules array
        $string .= "\n{$this->s(4)}]";

        return $string;
    }

    /**
     * Add a number of spaces.
     *
     * @param int
     * @return string
     */
    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }

    /**
     * Adjust the value to be compiled as a string.
     *
     * @param  mixed $value
     * @return mixed
     */
    protected function adjustValue($value, $escape = false)
    {
        if (is_null($value)) {
            $value = 'null';
        } elseif (is_bool($value)) {

            if ($value) {
                $value = 'true';
            } else {
                $value = 'false';
            }

        } elseif (!is_numeric($value) and !is_bool($value)) {

            if ($escape) {
                $value = addslashes($value);
            }

            $value = "'" . $value . "'";
        }

        return $value;
    }

    /**
     * Compile the relationship methods.
     *
     * @param StreamModel $stream
     * @return string
     */
    public function compileRelations(StreamModel $stream)
    {
        $string = '';

        foreach ($this->relationFields($stream) as $assignment) {

            $type = $assignment->getType();

            $type->setStream($stream);

            $relationString = '';

            $relationArray = $type->relation();

            $method = Str::camel($assignment->field->field_slug);

            $relationMethod = $relationArray['method'];

            $relationString .= "\n{$this->s(4)}public function {$method}()";

            $relationString .= "\n{$this->s(4)}{";

            $relationString .= "\n{$this->s(8)}return \$this->{$relationMethod}(";

            foreach ($relationArray['arguments'] as &$argument) {
                $argument = $this->adjustValue($argument);
            }

            $relationString .= implode(', ', $relationArray['arguments']);

            $relationString .= ");";

            $relationString .= "\n{$this->s(4)}}";

            $relationString .= "\n";

            $string .= $relationString;
        }

        return $string;
    }

    /**
     * Return the relation fields of a stream model.
     *
     * @param StreamModel $stream
     * @return mixed
     */
    protected function relationFields($stream)
    {
        return $this->relationFields = $this->relationFields ? : $stream->assignments->relations();
    }

    /**
     * Compile relation fields data
     *
     * @param StreamModel $stream
     * @return string
     */
    protected function compileRelationFieldsData(StreamModel $stream)
    {
        $string = "[";

        foreach ($this->relationFields($stream) as $assignment) {

            $relationArray = $assignment->getType()->relation();

            $key = $this->adjustValue($assignment->fieldSlug);

            $value = $this->adjustValue($relationArray['method']);

            $string .= "\n{$this->s(8)}{$key} => {$value},";
        }

        $string .= "\n{$this->s(4)}]";

        return $string;
    }

    /**
     * Return the compiled template for a model.
     *
     * @param array $data
     * @return string Compiled template
     */
    protected function template($data = [])
    {
        return str_replace(array_keys($data), $data, file_get_contents($this->templatePath()));
    }

    /**
     * Return the template path.
     *
     * @return string
     */
    public function templatePath()
    {
        return __DIR__ . '../../../../../../resources/assets/generator/EntryModelTemplate.txt';
    }
}
