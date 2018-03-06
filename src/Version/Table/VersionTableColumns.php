<?php namespace Anomaly\Streams\Platform\Version\Table;

use Illuminate\Contracts\Config\Repository;

/**
 * Class VersionTableColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VersionTableColumns
{

    /**
     * Handle the columns.
     *
     * @param VersionTableBuilder $builder
     * @param Repository          $config
     */
    public function handle(VersionTableBuilder $builder, Repository $config)
    {
        $date = $config->get('streams::datetime.date_format');
        $time = $config->get('streams::datetime.time_format');

        $builder->setColumns(
            [
                'created_at' => [
                    'heading'     => 'Date',
                    'sort_column' => 'created_at',
                    'wrapper'     => '
                    <strong>{value.datetime}</strong>
                    <br>
                    <small class="text-muted">{value.timeago}</small>',
                    'value'       => [
                        'datetime' => "entry.created_at.format('{$date} {$time}')",
                        'timeago'  => 'entry.created_at.diffForHumans()',
                    ],
                ],
            ]
        );
    }
}
