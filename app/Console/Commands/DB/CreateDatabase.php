<?php

namespace App\Console\Commands\DB;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use PDO;
use PDOException;
use DB;
use File;

class CreateDatabase extends Command
{
    protected $name = 'db:create';
    protected $description = 'Create database and base folder for the project';
    private $app;

    public function __construct(
        Application $app
    ) {
        $this->app = $app;
        parent::__construct();
    }

    public function handle()
    {

        $database = env('DB_DATABASE', false);

        if (! $database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return;
        }

        try {
            $pdo = $this->getPDOConnection(env('DB_HOST'), env('DB_PORT'), env('DB_USERNAME'), env('DB_PASSWORD'));

            $pdo->exec(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $database,
                env('DB_CHARSET'),
                env('DB_COLLATION')
            ));

            $this->info(sprintf('Successfully created %s database', $database));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $database, $exception->getMessage()));
        }
    }

    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}

