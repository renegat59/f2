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

    protected function buildQuery()
    {
        $query = 'SELECT '.$this->fields.' FROM '.$this->table.' ';
        $query .= $this->buildWhereClause();
        $query .= $this->buildGroupBy();
        $query .= $this->buildOrderBy();
        $query .= $this->buildLimit();
        return trim($query).';';
    }
}
