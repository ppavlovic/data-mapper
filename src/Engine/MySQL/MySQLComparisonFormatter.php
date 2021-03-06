<?php

namespace G4\DataMapper\Engine\MySQL;

use G4\DataMapper\Common\ComparisonFormatterInterface;
use G4\DataMapper\Common\ValueInterface;
use G4\DataMapper\Engine\MySQL\Quote;
use G4\DataMapper\Common\Selection\Operator;
use G4\DataMapper\Exception\InvalidValueException;

class MySQLComparisonFormatter implements ComparisonFormatterInterface
{

    private $map = [
        Operator::EQUAL                => '=',
        Operator::GRATER_THAN          => '>',
        Operator::GRATER_THAN_OR_EQUAL => '>=',
        Operator::IN                   => 'IN',
        Operator::LESS_THAN            => '<',
        Operator::LESS_THAN_OR_EQUAL   => '<=',
        Operator::LIKE                 => 'LIKE',
        Operator::NOT_EQUAL            => '<>',
        Operator::NOT_IN               => 'NOT IN',
        Operator::BETWEEN              => 'BETWEEN',
    ];

    public function format($name, Operator $operator, ValueInterface $value)
    {
        return sprintf(
            "%s %s %s",
            $name,
            $this->operatorMap($operator),
            $this->quote($value)
        );
    }

    private function quote($value)
    {
        return (string) new Quote($value);
    }

    private function operatorMap(Operator $operator)
    {
        $symbol = $operator->getSymbol();

        if (!isset($this->map[$symbol])) {
            throw new InvalidValueException('Operator not in map');
        }

        return $this->map[$symbol];
    }
}
