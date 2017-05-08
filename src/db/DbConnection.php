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

    public function select(string $fields): SelectQuery
    {
        return (new SelectQuery($this))->select($fields);
    }

    public function insertInto(string $table): InsertQuery
    {
        return (new InsertQuery($this))->insertInto($table);
    }

    public function update(string $table): UpdateQuery
    {
        return (new UpdateQuery($this))->update($table);
    }

    public function delete(string $table): DeleteQuery
    {
        return (new DeleteQuery($this))->delete($table);
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
