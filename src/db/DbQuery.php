<?php

namespace FTwo\db;

/**
 * Description of DbQuery
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DbQuery
{

    const SELECT = 'SELECT';
    const UPDATE = 'UPDATE';
    const INSERT = 'INSERT';
    const DELETE = 'DELETE';
    
    private $queryType;
    
    public function select(string $fields): DbQuery
    {
        $this->setQueryType(self::SELECT);
        return $this;
    }

    public function from(string $tableOrView): DbQuery
    {
        return $this;
    }

    public function where(string $condition, array $params): DbQuery
    {
        return $this;
    }
    
    public function andWhere(string $condition, array $params): DbQuery
    {
        return $this;
    }

    public function orWhere(string $condition, array $params): DbQuery
    {
        return $this;
    }

    public function orderBy(string $order): DbQuery
    {
        return $this;
    }

    public function groupBy(string $group): DbQuery
    {
        return $this;
    }

    public function limit(string $limit): DbQuery
    {
        return $this;
    }

    public function insertInto(string $table): DbQuery
    {
        $this->setQueryType(self::INSERT);
        return $this;
    }

    public function values(array $table): DbQuery
    {
        return $this;
    }

    public function update($table): DbQuery
    {
        $this->setQueryType(self::UPDATE);
        return $this;
    }

    public function set(array $values): DbQuery
    {
        return $this;
    }

    public function delete(string $fromTable): DbQuery
    {
        $this->setQueryType(self::DELETE);
        return $this;
    }

    public function join(string $joinType): DbQuery
    {
        return $this;
    }

    public function on(string $onCondition): DbQuery
    {
        return $this;
    }

    public function having(string $condition): DbQuery
    {
        return $this;
    }

    public function getQuery(): string
    {

    }

    public function execute(): array
    {
        return array();
    }

    public function executeOne()
    {
        $this->limit(1);
        $result = $this->execute();
        return $result[0] ?? null;
    }

    public function executeAs(string $className)
    {
        
    }

    public function executeOneAs(string $className)
    {
        $this->limit(1);
        $result = $this->executeAs($className);
        return $result[0] ?? null;
    }

    private function setQueryType(string $type)
    {
        if(null !== $this->queryType) {
            throw new \FTwo\core\exceptions\F2Exception('DbQuery can have only one Type');
        }
        $this->queryType = $type;
    }

}
