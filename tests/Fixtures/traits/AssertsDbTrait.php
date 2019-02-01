<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 19:10
 */

namespace Tests\Fixtures\traits;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Query\Builder;

/**
 * Trait AssertsDbTrait
 *
 * @property Capsule $connection
 *
 * @package Tests\Fixtures\traits
 */
trait AssertsDbTrait
{
    /**
     * @param string $tableName
     * @param $data
     */
    public function assertDatabaseMissing(string $tableName, array $data)
    {
        $query = $this->generateQuery($tableName, $data);

        $this->assertTrue($query->count() === 0, sprintf('Data found in table: %s', $tableName));
    }

    /**
     * @param string $tableName
     * @param $data
     */
    public function assertDatabaseHas(string $tableName, array $data)
    {
        $query = $this->generateQuery($tableName, $data);

        $this->assertTrue($query->count() > 0, sprintf('Data not found in table: %s', $tableName));
    }

    /**
     * @param string $tableName
     * @param array $data
     *
     * @return Builder
     */
    protected function generateQuery(string $tableName, array $data): Builder
    {
        $query = $this->connection->table($tableName);
        return $this->buildQuery($query, $data);
    }

    /**
     * @param Builder $query
     * @param array $data
     *
     * @return Builder
     */
    protected function buildQuery(Builder $query, array $data): Builder
    {
        foreach ($data as $columnName => $value) {
            $query = $query->where($columnName, $value);
        }

        return $query;
    }
}