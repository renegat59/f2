<?php

namespace FTwo\db;

/**
 * Description of Update
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class UpdateQuery extends Query
{
    private $values;

    public function update($table): Query
    {
        $this->table = $table;
        return $this;
    }

    protected function buildQuery()
    {
        $query = 'UPDATE '.$this->table.' ';
        $query .= 'SET '.$this->buildValues();
        return trim($query).';';
    }

    public function set(array $values): Query
    {
        $this->values = $values;
        return $this;
    }

    private function buildValues()
    {
        return implode(', ',
            array_map(function($field) {
                return $field.'=:'.$field;
            }, array_keys($this->values)));
    }
}
