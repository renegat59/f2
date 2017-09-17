<?php

namespace FTwo\db;

/**
 * Description of DbConnection
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DbConnection extends \FTwo\core\Component
{
    private $dbConn;

    public function __construct($config)
    {
        $this->dbConn = new H2Orm\connection\DbConnection($config);
    }

    public function getConnetion()
    {
        return $this->dbConn;
    }
}
