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
    protected $params;
    protected $orderBy;
    protected $groupBy;
    protected $limit;

    abstract protected function buildQuery();

    public function __construct($connection)
    {
        $this->dbConnection = $connection;
    }

    public function setDbConnection(DbConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function where(string $condition, array $params=array()): Query
    {
        $this->whereClause = $condition;
        $this->params = $params;
        return $this;
    }

    public function andWhere(string $condition, array $params): Query
    {
        $this->addWhere($condition, 'AND');
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function orWhere(string $condition, array $params): Query
    {
        $this->addWhere($condition, 'OR');
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    private function addWhere(string $whereClause, string $operator)
    {
        if (!empty($this->where)) {
            throw new \FTwo\core\exceptions\F2Exception('where() not called before');
        }
        if(!empty($whereClause)) {
            $this->whereClause = '('.$this->whereClause.') '.$operator.' '.$whereClause;
        }
        return $this;
    }

    public function orderBy(string $order): Query
    {
        $this->orderBy = $order;
        return $this;
    }

    public function groupBy(string $group): Query
    {
        $this->groupBy = $group;
        return $this;
    }

    public function limit(string $limit): Query
    {
        $this->limit = $limit;
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
     * @return type found element casted to given object or null if result is empty
     */
    public function executeOneAs(string $className)
    {
        $this->limit(1);
        $result = $this->executeAs($className);
        return $result[0] ?? null;
    }

    protected function buildWhereClause(){
        if(!empty($this->whereClause)){
            return 'WHERE '.$this->whereClause.' ';
        }
        return '';
    }

    protected function buildOrderBy(){
        if(!empty($this->orderBy)){
            return 'ORDER BY '.$this->orderBy.' ';
        }
        return '';
    }

    protected function buildLimit(){
        if(!empty($this->limit)){
            return 'LIMIT '.$this->limit.' ';
        }
        return '';
    }

    protected function buildGroupBy(){
        if(!empty($this->groupBy)){
            return 'GROUP BY '.$this->groupBy.' ';
        }
        return '';
    }
}
