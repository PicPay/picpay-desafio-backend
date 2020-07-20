<?php

class TestingApp
{
    private $config;

    private static $PDOConnection;

    private $app;

    public function __construct()
    {
        $this->app = require 'app.php';

        $this->config = require 'config/database.php';

        $this->createTestingDB();

        return $this->app;
    }

    private function getPDOConnection()
    {
        if (is_null(self::$PDOConnection)) {
            $driver = $this->config['connections']['testing']['driver'];

            $host = $this->config['connections']['testing']['host'];
            $port = $this->config['connections']['testing']['port'];
            $username = $this->config['connections']['testing']['username'];
            $password = $this->config['connections']['testing']['password'];

            self::$PDOConnection = new PDO(
                "{$driver}:host={$host};port={$port}",
                $username,
                $password
            );
        }

        return self::$PDOConnection;
    }

    private function createTestingDB()
    {
        $connection = $this->getPDOConnection();

        $databaseName = $this->config['connections']['testing']['database'];

        $dbname = '`'.str_replace('`', '``', $databaseName).'`';

        $connection->exec("CREATE DATABASE IF NOT EXISTS $dbname");

        $connection->exec("use $dbname");
    }
}

return new TestingApp();
