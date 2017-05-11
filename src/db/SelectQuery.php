<?php

namespace FTwo\db;

/**
 * Description of Select
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class SelectQuery extends Query
{
    private $fields;
    private $joins = [];

    public function select(string $fields): SelectQuery
    {
        $this->fields = $fields;
        return $this;
    }

    public function from(string $table): SelectQuery
    {
        $this->table = $table;
        return $this;
    }

    public function join(string $joinTable): Query
    {
        $this->addJoin('INNER JOIN', $joinTable);
        return $this;
    }

    public function leftJoin(string $joinTable): Query
    {
        $this->addJoin('LEFT JOIN', $joinTable);
        return $this;
    }

    public function rightJoin(string $joinTable): Query
    {
        $this->addJoin('RIGHT JOIN', $joinTable);
        return $this;
    }

    public function fullOuterJoin(string $joinTable): Query{
        $this->addJoin('FULL OUTER JOIN', $joinTable);
        return $this;
    }

    private function addJoin(string $joinType, string $table)
    {
        $this->joins[] = $joinType.' '.$table;
    }

    protected function buildQuery()
    {
        $query = 'SELECT '.$this->fields.' FROM '.$this->table.' ';
        $query .= $this->buildJoins();
        $query .= $this->buildWhereClause();
        $query .= $this->buildGroupBy();
        $query .= $this->buildOrderBy();
        $query .= $this->buildLimit();
        return trim($query).';';
    }

    private function buildJoins(): string
    {
        if (!empty($this->joins)) {
            return implode(' ', $this->joins).' ';
        }
        return '';
    }
}
