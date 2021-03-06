<?php

declare(strict_types=1);

namespace Doctrine\Tests\Mocks;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use function array_shift;
use function current;
use function is_array;
use function next;

/**
 * This class is a mock of the Statement interface that can be passed in to the Hydrator
 * to test the hydration standalone with faked result sets.
 */
class HydratorMockStatement implements IteratorAggregate, Statement
{
    /** @var array */
    private $resultSet;

    /**
     * Creates a new mock statement that will serve the provided fake result set to clients.
     *
     * @param array $resultSet The faked SQL result set.
     */
    public function __construct(array $resultSet)
    {
        $this->resultSet = $resultSet;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($fetchMode = null, ...$args) : array
    {
        return $this->resultSet;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn($columnNumber = 0)
    {
        $row = current($this->resultSet);
        if (! is_array($row)) {
            return false;
        }
        $val = array_shift($row);

        return $val ?? false;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($fetchMode = null, ...$args)
    {
        $current = current($this->resultSet);
        next($this->resultSet);

        return $current;
    }

    /**
     * {@inheritdoc}
     */
    public function closeCursor() : void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = ParameterType::STRING) : void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null) : void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function columnCount() : int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute($params = null) : void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rowCount() : int
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->resultSet;
    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode($fetchMode, ...$args) : void
    {
    }
}
