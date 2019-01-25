<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 18:43
 */

namespace Tests\Fixtures\traits;

use Tests\Fixtures\ActiveFixture;

/**
 * Trait FixtureTrait
 *
 * @method ActiveFixture[] fixtures():
 *
 * @package Tests\Fixtures\traits
 */
trait FixtureTrait
{
    public function initFixtures()
    {
        $this->unloadFixtures();
        $this->loadFixtures();
    }

    public function unloadFixtures()
    {
        $activeFixtures = $this->fixtures();

        foreach($activeFixtures as $activeFixture) {
            $fixture = $this->createInstance($activeFixture);
            $fixture->unload();
        }
    }

    public function loadFixtures()
    {
        $activeFixtures = $this->fixtures();

        foreach($activeFixtures as $activeFixture) {
            $fixture = $this->createInstance($activeFixture);
            $fixture->load();
        }
    }

    public function createInstance($activeFixtureClass)
    {
        return new $activeFixtureClass;
    }
}