<?php

namespace FTwo\db;

/**
 * Description of Query
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class Query
{
    protected $dbConnection;
    protected $table;
    protected $whereClause;

    abstract protected function buildQuery();

    public function __construct($connection)
    {
        $this->dbConnection = $connection;
    }

    public function setDbConnection(DbConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function where(string $condition, array $params): Query
    {
        $whereCondition = $this->prepareCondition($condition, $params);
        $this->whereClause = $whereCondition;
        return $this;
    }

    public function andWhere(string $condition, array $params): Query
    {
        if (!empty($this->where)) {
            throw new \FTwo\core\exceptions\F2Exception('Can not call andWhere() before where()');
        }
        $whereCondition = $this->prepareCondition($condition, $params);
        $this->addWhere($whereCondition, 'AND');
        return $this;
    }

    public function orWhere(string $condition, array $params): Query
    {
        if (!empty($this->where)) {
            throw new \FTwo\core\exceptions\F2Exception('Can not call orWhere() before where()');
        }
        $whereCondition = $this->prepareCondition($condition, $params);
        $this->addWhere($whereCondition, 'AND');
        return $this;
    }

    private function addWhere(string $whereClause, string $operator)
    {
        return $this;
    }

    public function orderBy(string $order): Query
    {
        return $this;
    }

    public function groupBy(string $group): Query
    {
        return $this;
    }

    public function limit(string $limit): Query
    {
        return $this;
    }

    public function values(array $table): Query
    {
        return $this;
    }

    public function set(array $values): Query
    {
        return $this;
    }

    public function join(string $joinType): Query
    {
        return $this;
    }

    public function on(string $onCondition): Query
    {
        return $this;
    }

    public function having(string $condition): Query
    {
        return $this;
    }

    /**
     * Gets the formed query instead of executing it.
     * @return string formed query
     */
    public function getQuery(): string
    {
        return $this->buildQuery();
    }

    public function execute(): array
    {
        return array();
    }

    /**
     * Executes the query and returns one result. It applies "limit 1" explicitly.
     * Returns the result or null if result set is empty
     * @return type found element or null
     */
    public function executeOne()
    {
        $this->limit(1);
        $result = $this->execute();
        return $result[0] ?? null;
    }

    public function executeAs(string $className)
    {
        
    }

    /**
     * Executes the query and returns one result casted to the given class. It applies "limit 1" explicitly.
     * Returns the result or null if result set is empty
     * @return type found element casted to gicen object or null if result is empty
     */
    public function executeOneAs(string $className)
    {
        $this->limit(1);
        $result = $this->executeAs($className);
        return $result[0] ?? null;
    }
}
