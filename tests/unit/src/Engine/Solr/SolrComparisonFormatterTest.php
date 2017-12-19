<?php

use G4\DataMapper\Engine\Solr\SolrComparisonFormatter;
use G4\DataMapper\Common\Selection\Operator;

class SolrComparisonFormatterTest extends PHPUnit_Framework_TestCase
{

    private $comparisonFormatter;

    private $operatorMock;

    protected function setUp()
    {
        $this->comparisonFormatter = new SolrComparisonFormatter();

        $this->operatorMock = $this->getMockBuilder(\G4\DataMapper\Common\Selection\Operator::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->comparisonFormatter = null;
        $this->operatorMock        = null;
    }

    public function testEqual()
    {
        $this->operatorMock->expects($this->any())
            ->method('getSymbol')
            ->willReturn(Operator::EQUAL);

        $this->assertEquals('name:test', $this->comparisonFormatter->format('name', $this->operatorMock, 'test'));
    }

    public function testGreaterThan()
    {
        $this->operatorMock->expects($this->any())
            ->method('getSymbol')
            ->willReturn(Operator::GRATER_THAN);

        $this->assertEquals('age:{18 TO *}', $this->comparisonFormatter->format('age', $this->operatorMock, '18'));
    }

    public function testLessThan()
    {
        $this->operatorMock->expects($this->any())
            ->method('getSymbol')
            ->willReturn(Operator::LESS_THAN);

        $this->assertEquals('age:{* TO 18}', $this->comparisonFormatter->format('age', $this->operatorMock, '18'));
    }

    public function testGreaterThanOrEqual()
    {
        $this->operatorMock->expects($this->any())
            ->method('getSymbol')
            ->willReturn(Operator::GRATER_THAN_OR_EQUAL);

        $this->assertEquals('age:[18 TO *]', $this->comparisonFormatter->format('age', $this->operatorMock, '18'));
    }

    public function testLessThanOrEqual()
    {
        $this->operatorMock->expects($this->any())
            ->method('getSymbol')
            ->willReturn(Operator::LESS_THAN_OR_EQUAL);

        $this->assertEquals('age:[* TO 18]', $this->comparisonFormatter->format('age', $this->operatorMock, '18'));
    }

    public function testIn()
    {
        $this->operatorMock->expects($this->any())
            ->method('getSymbol')
            ->willReturn(Operator::IN);

        $this->assertEquals('age:(18 OR 19 OR 20)', $this->comparisonFormatter->format('age', $this->operatorMock, '18, 19, 20'));
    }
}