<?php

use PHPUnit\Framework\TestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsertQueryTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class InsertQueryTest extends TestCase
{
    private $insertQuery;

    public function setUp()
    {
        parent::setUp();
        //todo: replace null with dbconnection
        $this->insertQuery = new FTwo\db\InsertQuery(null);
    }

    public function testInsertInto()
    {
        $this->assertNotNull($this->insertQuery->insertInto('table1')->values(['a' => 1]));
        $this->assertEquals('INSERT INTO table1 (a) VALUES (:a);', $this->insertQuery->getQuery());
        $this->assertEquals('INSERT INTO table2 (a) VALUES (:a);', $this->insertQuery->insertInto('table2')->getQuery()
        );
    }

    public function testInsertIntoWithParams()
    {
        $query = $this->insertQuery->insertInto('table1')
            ->values([
                'name' => 'name1',
                'age' => 34
            ])
            ->getQuery();
        $this->assertEquals("INSERT INTO table1 (name, age) VALUES (:name, :age);", $query);
    }
}
