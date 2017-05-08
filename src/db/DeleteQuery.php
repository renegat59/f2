<?php

namespace FTwo\db;

/**
 * Description of Delete
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DeleteQuery extends Query
{
    public function delete(string $fromTable): Query
    {
        return $this;
    }

    protected function buildQuery()
    {

    }
}
