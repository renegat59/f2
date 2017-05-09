<?php

use PHPUnit\Framework\TestCase;

/**
 * Description of SelectQueryTest
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class SelectQueryTest extends TestCase
{
    /**
     * @var SelectQuery
     */
    private $selectQuery;

    public function setUp()
    {
        parent::setUp();
        //todo: replace null with dbconnection
        $this->selectQuery = new FTwo\db\SelectQuery(null);
    }

    public function testSelect()
    {
        $select = $this->selectQuery->select('field1, field2');
        $this->assertNotNull($select);
        $this->assertEquals('SELECT field1, field2 FROM;', $select->getQuery());
        $select->select('field3');
        $this->assertEquals('SELECT field3 FROM;', $select->getQuery());
    }

    public function testFrom()
    {
        $select = $this->selectQuery->select('field1, field2')->from('table1');
        $this->assertNotNull($select);
        $this->assertEquals('SELECT field1, field2 FROM table1;', $select->getQuery());
        $select->from('table2');
        $this->assertEquals('SELECT field1, field2 FROM table2;', $select->getQuery());
    }

    public function testGetQuery()
    {
        $query = $this->selectQuery
            ->select('field1, field2')
            ->from('table1')
            ->where('a=b')
            ->orderBy('field3')
            ->limit(3)
            ->groupBy('field2')
            ->getQuery();
        $this->assertEquals('SELECT field1, field2 FROM table1 WHERE a=b GROUP BY field2 ORDER BY field3 LIMIT 3;', $query);
    }
}
