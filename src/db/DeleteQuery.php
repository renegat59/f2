<?php

namespace FTwo\db;

/**
 * Description of Delete
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DeleteQuery extends Query
{

    public function from(string $table): Query
    {
        $this->table = $table;
        return $this;
    }

    protected function buildQuery()
    {
        $query = 'DELETE FROM '.$this->table.' ';
        $query .= $this->buildWhereClause();
        $query .= $this->buildOrderBy();
        $query .= $this->buildLimit();
        return trim($query).';';
    }
}
