<?php

namespace FTwo\db;

/**
 * Description of INsert
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class InsertQuery extends Query
{
    public function insertInto(string $table): Query
    {
        return $this;
    }

    protected function buildQuery()
    {

    }
}
