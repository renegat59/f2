<?php

namespace FTwo\db;

use FTwo\core\Component;
use FTwo\core\exceptions\F2Exception;
use PDO;

/**
 * Description of DbConnection
 *
 * @author mateusz
 */
class DbConnection extends Component
{
    private $databaseHandler;

    public function __construct($config)
    {
        $this->validateConfig($config);

        $host   = $config['host'];
        $dbName = $config['schema'];
        $port   = $config['port'] ?? 3306;

        $connectionString      = "mysql:host=$host;port=$port;dbname=$dbName";
        $this->databaseHandler = new PDO($connectionString, $config['user'], $config['password']);
    }

    private function validateConfig($config)
    {
        if (!isset($config['host'])) {
            throw new F2Exception('Database host not provided');
        }

        if (!isset($config['user'])) {
            throw new F2Exception('Database user not provided');
        }

        if (!isset($config['password'])) {
            throw new F2Exception('Database password not provided');
        }

        if (!isset($config['schema'])) {
            throw new F2Exception('Database schema not provided');
        }
    }
}
