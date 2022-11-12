<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;

/**
 * Class DatabaseCreateCommand
 * @package App\Console\Commands
 */
class DatabaseCreateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a new database';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $driver = env('DB_CONNECTION', 'mysql');
        $databaseData = config('database.connections');
        if (empty($databaseData[$driver])) {
            Log::error('Invalid database driver.');
            return;
        }
        $databaseData = $databaseData[$driver];

        $database = $databaseData['database'];

        if (!$database) {
            $this->info('Skipping creation of database as database is empty');
            return;
        }

        try {
            $pdo = $this->getPDOConnection($databaseData['host'], $databaseData['port'], $databaseData['username'], $databaseData['password']);

            $pdo->exec(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $database,
                $databaseData['charset'],
                $databaseData['collation']
            ));

            $this->info(sprintf('Successfully created %s database', $database));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $database, $exception->getMessage()));
        }
    }

    /**
     * @param  string $host
     * @param  integer $port
     * @param  string $username
     * @param  string $password
     * @return PDO
     */
    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
