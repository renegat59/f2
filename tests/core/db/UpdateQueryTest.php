<?php

use FTwo\db\UpdateQuery;
use PHPUnit\Framework\TestCase;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateQueryClass
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class UpdateQueryTest extends TestCase
{
    private $updateQuery;

    public function setUp()
    {
        parent::setUp();
        //todo: replace null with dbconnection
        $this->updateQuery = new UpdateQuery(null);
    }

    /**
     * @covers \FTwo\db\UpdateQuery::update()
     */
    public function testUpdate()
    {
        $this->assertNotNull($this->updateQuery->update('table1'));
        $this->updateQuery->set(['a'=>1]);
        $this->assertEquals('UPDATE table1 SET a=:a;',$this->updateQuery->getQuery());
        $this->assertNotNull($this->updateQuery->update('table2'));
        $this->assertEquals('UPDATE table2 SET a=:a;',$this->updateQuery->getQuery());
    }

    /**
     * @covers \FTwo\db\UpdateQuery::set()
     */
    public function testSet()
    {
        $this->assertNotNull($this->updateQuery->update('table1'));
        $this->updateQuery->set(['field1'=>1, 'field2'=>'value2']);
        $this->assertEquals('UPDATE table1 SET field1=:field1, field2=:field2;',$this->updateQuery->getQuery());
    }
}
