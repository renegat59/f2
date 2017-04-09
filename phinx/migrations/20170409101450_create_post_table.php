<?php

use Phinx\Migration\AbstractMigration;

class CreatePostTable extends AbstractMigration
{

  public function change()
  {
    $postTable = $this->table('post');
    $postTable
        ->addColumn('title', 'string', ['limit' => 255])
        ->addColumn('content', 'text')
        ->addColumn('created', 'datetime')
        ->addColumn('updated', 'datetime')
        ->addColumn('published', 'boolean')
        ->create();
  }
}