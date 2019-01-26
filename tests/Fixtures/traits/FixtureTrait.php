<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 18:43
 */

namespace Tests\Fixtures\traits;

use Illuminate\Database\Capsule\Manager as Capsule;
use Tests\Fixtures\ActiveFixture;

/**
 * Trait FixtureTrait
 *
 * @property Capsule $db
 *
 * @method ActiveFixture[] fixtures():
 *
 * @package Tests\Fixtures\traits
 */
trait FixtureTrait
{
    /**
     * @var ActiveFixture[]|array
     */
    protected $activeFixtures;

    public function initFixtures(): void
    {
        $this->activeFixtures = $this->createInstances($this->fixtures());

        $this->unloadFixtures($this->activeFixtures);
        $this->loadFixtures($this->activeFixtures);
    }

    public function destroyFixtures()
    {
        $this->unloadFixtures($this->activeFixtures);
    }

    /**
     * @param ActiveFixture[] $activeFixtures
     */
    public function unloadFixtures(array $activeFixtures): void
    {
        foreach ($activeFixtures as $activeFixture) {
            $dependencies = $this->createInstances($activeFixture->dependencies);
            $this->unload($activeFixture);

            $this->unloadFixtures($dependencies);
        }
    }

    /**
     * @param ActiveFixture[] $activeFixtures
     */
    public function loadFixtures(array $activeFixtures): void
    {
        foreach ($activeFixtures as $activeFixture) {
            $dependencies = $this->createInstances($activeFixture->dependencies);
            $this->loadFixtures($dependencies);

            $this->load($activeFixture);
        }
    }

    /**
     * @param array $activeFixtureClasses
     *
     * @return ActiveFixture[]
     */
    private function createInstances(array $activeFixtureClasses): array
    {
        $result = [];

        foreach ($activeFixtureClasses as $activeFixtureClass) {
            $result[] = $this->createInstance($activeFixtureClass);
        }

        return $result;
    }

    private function createInstance($activeFixtureClass): ActiveFixture
    {
        return new $activeFixtureClass();
    }

    private function unload(ActiveFixture $fixture): void
    {
        $this->db->getConnection()->table($fixture->tableName)->delete();
    }

    private function load(ActiveFixture $fixture): void
    {
        $this->db->getConnection()->table($fixture->tableName)->insert($fixture->getData());
    }
}