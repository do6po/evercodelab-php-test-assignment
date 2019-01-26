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
 * @property Capsule $db
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

        $this->assertTrue($query->count() === 0, 'Data found in database');
    }

    /**
     * @param string $tableName
     * @param $data
     */
    public function assertDatabaseHas(string $tableName, array $data)
    {
        $query = $this->generateQuery($tableName, $data);

        $this->assertTrue($query->count() > 0, 'Data not found in db');
    }

    /**
     * @param string $tableName
     * @param array $data
     *
     * @return Builder
     */
    protected function generateQuery(string $tableName, array $data): Builder
    {
        $query = $this->db->getConnection()->table($tableName);
        return $this->buildQuery($query, $data);
    }

    /**
     * @param $builder
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildQuery(Builder $builder, array $data): Builder
    {
        foreach ($data as $columnName => $value) {
            $builder = $builder->where($columnName, $value);
        }

        return $builder;
    }
}