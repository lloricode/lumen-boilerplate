<?php

declare(strict_types=1);

namespace Test;

//use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\File;

/**
 * Trait UsesDatabase
 *
 * @package Tests
 * @reference https://github.com/spatie/blender/blob/master/tests/Concerns/UsesDatabase.php
 */
trait UsesDatabase
{
    /** @var bool */
    protected static $migrated = false;

    /** @var string */
    protected $database = __DIR__.'/../database/database.sqlite';
    protected $databaseCopy = __DIR__.'/../database/database-copy.sqlite';

    public function prepareDatabase($force = false)
    {
        // The database needs to be deleted before the application gets boted
        // to avoid having the database in a weird read-only state.

        if ( ! $force && static::$migrated) {
            return;
        }

        @unlink($this->databaseCopy);
        @unlink($this->database);
        touch($this->database);
    }

    /** Refresh the database to a clean version. */
    public function refreshDatabase(): void
    {
        if (File::exists($this->databaseCopy)) {
            File::copy($this->databaseCopy, $this->database);
        } else {
            File::copy($this->database, $this->databaseCopy);
        }
    }

    public function setUpDatabase(callable $afterMigrations = null)
    {
        if (static::$migrated) {
            return;
        }

        $this->artisan('migrate');

        //$this->app[Kernel::class]->setArtisan(null);

        if ($afterMigrations) {
            $afterMigrations();
        }

        static::$migrated = true;
    }

    public function beginDatabaseTransaction()
    {
        $database = $this->app->make('db');

        foreach ($this->connectionsToTransact() as $name) {
            $database->connection($name)->beginTransaction();
        }

        $this->beforeApplicationDestroyed(
            function () use ($database) {
                foreach ($this->connectionsToTransact() as $name) {
                    $connection = $database->connection($name);

                    $connection->rollBack();
                    $connection->disconnect();
                }
            }
        );
    }

    protected function connectionsToTransact()
    {
        return property_exists($this, 'connectionsToTransact') ? $this->connectionsToTransact : [null];
    }
}
