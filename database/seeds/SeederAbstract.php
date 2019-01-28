<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 18:59
 */

namespace database\seeds;


use database\traits\DbConfigTrait;
use Phinx\Seed\AbstractSeed;

abstract class SeederAbstract extends AbstractSeed
{
    use DbConfigTrait;
}