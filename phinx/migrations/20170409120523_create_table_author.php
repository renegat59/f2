<?php

use Phinx\Migration\AbstractMigration;

class CreateTableAuthor extends AbstractMigration
{
    public function change()
    {
      $authorTable = $this->table('author');
      $authorTable
          ->addColumn('full_name', 'string', ['limit'=>255])
          ->addColumn('alias', 'string', ['limit'=>64])
          ->addColumn('password', 'string', ['limit'=>64])
          ->create();
    }
}
