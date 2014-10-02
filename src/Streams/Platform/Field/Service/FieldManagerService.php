<?php namespace Streams\Platform\Field\Service;

use Laracasts\Commander\CommanderTrait;
use Streams\Platform\Addon\AddonInterface;
use Streams\Platform\Field\Command\AddFieldCommand;
use Streams\Platform\Field\Command\RemoveFieldCommand;

class FieldManagerService
{
    use CommanderTrait;

    /**
     * Add a field.
     *
     * @param AddonInterface $addon
     * @param array          $field
     * @return mixed
     */
    public function add(AddonInterface $addon, array $field)
    {
        $slug      = evaluate_key($field, 'slug', null, [$addon]);
        $rules     = evaluate_key($field, 'rules', [], [$addon]);
        $settings  = evaluate_key($field, 'settings', [], [$addon]);
        $type      = evaluate_key($field, 'type', null, [$addon]);
        $isLocked  = evaluate_key($field, 'is_locked', true, [$addon]);
        $namespace = evaluate_key($field, 'namespace', $addon->getSlug(), [$addon]);

        $mergeData = array_merge(compact('namespace', 'slug'), ['type' => $addon->getType()]);

        $name = merge(app('config')->get('streams.field.name'), $mergeData);

        $name = evaluate_key($field, 'name', $name, [$addon]);

        $command = new AddFieldCommand($namespace, $slug, $type, $name, $settings, $rules, $isLocked);

        return $this->execute($command);
    }

    /**
     * Remove a field.
     *
     * @param AddonInterface $addon
     * @param array          $field
     * @return mixed
     */
    public function remove(AddonInterface $addon, array $field)
    {
        $slug      = evaluate_key($field, 'slug', null, [$addon]);
        $namespace = evaluate_key($field, 'namespace', $addon->getSlug(), [$addon]);

        $command = new RemoveFieldCommand($namespace, $slug);

        return $this->execute($command);
    }
}
