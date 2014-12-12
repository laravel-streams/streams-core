<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Illuminate\Database\Schema\Blueprint;

/**
 * Class InstallStreamsTablesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\Distribution\Streams\Command
 */
class InstallStreamsTablesCommandHandler
{

    /**
     * The db object.
     *
     * @var mixed
     */
    protected $db;

    /**
     * The schema object.
     *
     * @var
     */
    protected $schema;

    /**
     * Create a new InstallStreamsTablesCommandHandler instance.
     */
    function __construct()
    {
        $this->db     = app('db');
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Handle the command.
     */
    public function handle(InstallStreamsTablesCommand $command)
    {
        $this->installStreamsTable();
        $this->installStreamsTranslationsTable();

        $this->installFieldsTable();
        $this->installFieldsTranslationsTable();

        $this->installAssignmentsTable();
        $this->installAssignmentsTranslationsTable();
    }

    /**
     * Install the streams table.
     */
    protected function installStreamsTable()
    {
        $this->schema->dropIfExists('streams_streams');

        $this->schema->create(
            'streams_streams',
            function (Blueprint $table) {

                $table->increments('id');
                $table->string('namespace');
                $table->string('slug');
                $table->string('prefix')->nullable();
                $table->string('name');
                $table->string('description')->nullable();
                $table->text('view_options');
                $table->string('title_column');
                $table->string('order_by');
                $table->string('hidden')->default(0);
                $table->string('translatable')->default(0);
                $table->string('revisionable')->default(0);
            }
        );
    }

    /**
     * Install the streams translations table.
     */
    protected function installStreamsTranslationsTable()
    {
        $this->schema->dropIfExists('streams_streams_translations');

        $this->schema->create(
            'streams_streams_translations',
            function (Blueprint $table) {

                $table->increments('id');
                $table->integer('stream_id');
                $table->string('locale')->index();

                $table->string('name');
                $table->string('description')->nullable();
            }
        );
    }

    /**
     * Install the fields table.
     */
    protected function installFieldsTable()
    {
        $this->schema->dropIfExists('streams_fields');

        $this->schema->create(
            'streams_fields',
            function (Blueprint $table) {

                $table->increments('id');
                $table->string('namespace');
                $table->string('slug');
                $table->string('name');
                $table->string('type');
                $table->text('config');
                $table->text('rules');
                $table->boolean('locked')->default(0);
            }
        );
    }

    /**
     * Install the fields translations table.
     */
    protected function installFieldsTranslationsTable()
    {
        $this->schema->dropIfExists('streams_fields_translations');

        $this->schema->create(
            'streams_fields_translations',
            function (Blueprint $table) {

                $table->increments('id');
                $table->integer('field_id');
                $table->string('locale')->index();

                $table->string('name');
            }
        );
    }

    /**
     * Install the assignments table.
     */
    protected function installAssignmentsTable()
    {
        $this->schema->dropIfExists('streams_assignments');

        $this->schema->create(
            'streams_assignments',
            function (Blueprint $table) {

                $table->increments('id');
                $table->integer('sort_order');
                $table->integer('stream_id');
                $table->integer('field_id');
                $table->string('label')->nullable();
                $table->string('placeholder')->nullable();
                $table->text('instructions')->nullable();
                $table->boolean('unique')->default(0);
                $table->boolean('required')->default(0);
                $table->boolean('translatable')->default(0);
            }
        );
    }

    /**
     * Install the assignments translations table.
     */
    protected function installAssignmentsTranslationsTable()
    {
        $this->schema->dropIfExists('streams_assignments_translations');

        $this->schema->create(
            'streams_assignments_translations',
            function (Blueprint $table) {

                $table->increments('id');
                $table->integer('assignment_id');
                $table->string('locale')->index();

                $table->string('label')->nullable();
                $table->string('placeholder')->nullable();
                $table->text('instructions')->nullable();
            }
        );
    }
}
