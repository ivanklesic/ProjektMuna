<?php declare(strict_types = 1);

namespace App\Core\Data;

use App\Core\Config;

class Database extends  \PDO
{
    private static $instance;

    private function __clone()
    {
    }

    private function __construct()
    {
        $dbConfig = Config::get('db_local');

        $dsn = 'pgsql:host='.$dbConfig['host'].';port='.$dbConfig['port'].';dbname='.$dbConfig['name'].';user='.$dbConfig['user'].';password='.$dbConfig['password'];

        parent::__construct($dsn);

        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}