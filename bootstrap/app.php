<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 18:30
 */

$app = app();
app()->singleton('app', $app);

return $app;