<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 10:34
 */

require_once "../lib/Log.php";
$log = new \lib\Log();
$log->info("hello!");
$log->warning("hello!");
$log->debug("hello!");
$log->error("hello!");