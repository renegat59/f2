<?php

namespace FTwo\db;

use FTwo\core\Component;

/**
 * Description of DbConnection
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DbConnection extends Component
{
    private $dbConn;

    public function __construct($config)
    {
        $this->dbConn = new \H2Orm\core\DbConnection($config);
    }

    public function getConnetion()
    {
        return $this->dbConn;
    }
}
