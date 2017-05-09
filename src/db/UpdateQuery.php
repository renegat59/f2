<?php

namespace FTwo\db;

/**
 * Description of Update
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class UpdateQuery extends Query
{

    public function update($table): Query
    {
        return $this;
    }

    protected function buildQuery()
    {

    }

    public function set(array $values): Query
    {
        return $this;
    }
}
