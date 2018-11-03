<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 03/11/2018
 * Time: 6:38 PM
 */

use Lvinkim\Crontab\Crontab;

require dirname(__DIR__) . "/../vendor/autoload.php";

$configPath = dirname(__DIR__) . "/config/crontab.ini";

$crontab = new Crontab($configPath);
$crontab->run(10 * 1000);
