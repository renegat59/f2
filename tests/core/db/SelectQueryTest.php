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
        $this->assertNotNull($this->selectQuery->select('field1, field2'));
        $this->assertEquals('SELECT field1, field2 FROM;', $this->selectQuery->getQuery());
        $this->selectQuery->select('field3');
        $this->assertEquals('SELECT field3 FROM;', $this->selectQuery->getQuery());
    }


    public function testFrom()
    {
        $this->assertNotNull($this->selectQuery->select('field1, field2')->from('table1'));
        $this->assertEquals('SELECT field1, field2 FROM table1;', $this->selectQuery->getQuery());
        $this->selectQuery->from('table2');
        $this->assertEquals('SELECT field1, field2 FROM table2;', $this->selectQuery->getQuery());
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

    public function testGetQueryWithParams()
    {
        $query = $this->selectQuery
            ->select('field1, field2')
            ->from('table1')
            ->where('a=:a', [':a'=>1])
            ->orderBy('field3')
            ->limit(3)
            ->groupBy('field2')
            ->getQuery();
        $this->assertEquals('SELECT field1, field2 FROM table1 WHERE a=:a GROUP BY field2 ORDER BY field3 LIMIT 3;', $query);
    }
}
