<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 19:10
 */

namespace Tests\Fixtures\traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait AssertsDbTrait
{
    /**
     * @param string|Model $className
     * @param $data
     */
    public function assertDatabaseMissing(string $className, array $data)
    {
        $query = $this->generateQuery($className, $data);

        $this->assertTrue($query->count() === 0, 'Data found in database');
    }

    /**
     * @param string|Model $className
     * @param $data
     */
    public function assertDatabaseHas(string $className, array $data)
    {
        $query = $this->generateQuery($className, $data);

        $this->assertTrue($query->count() > 0, 'Data not found in db');
    }

    /**
     * @param string|Model $className
     * @param array $data
     * @return Builder
     */
    protected function generateQuery(string $className, array $data): Builder
    {
        return $this->buildQuery($className::query(), $data);
    }

    protected function buildQuery(Builder $builder, array $data): Builder
    {
        foreach ($data as $columnName => $value) {
            $builder = $builder->where($columnName, $value);
        }

        return $builder;
    }
}