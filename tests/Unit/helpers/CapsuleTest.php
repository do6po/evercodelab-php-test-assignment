<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 18:33
 */

namespace Tests\Unit\helpers;


use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\DatabaseManager;
use Tests\TestCase;

class CapsuleTest extends TestCase
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testCapsule()
    {
        $capsule = app()->make('db');

        $this->assertInstanceOf(Manager::class, $capsule);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testDatabaseManager()
    {
        $capsule = app()->make('db');

        $this->assertInstanceOf(DatabaseManager::class, $capsule->getDatabaseManager());
    }
}