<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 22:53
 */

require_once "../lib/RR.php";
require_once "../lib/Log.php";
require_once "../sql/SQLHelper.php";

$uid = $_POST['uid'] ?? 0;
$publish_id = $_POST['publish_id'] ?? 0;

$log = new \lib\Log();
$rr = new \lib\RR("task@view");
$sql = new \SQL\SQLHelper();
$rr->recv($_POST);

if ($uid <= 0 || $publish_id <= 0) {
    $rr->send(-1, "参数错误", $_POST);
}

$query = "update task_publish_info set viewed=viewed+1 where publish_id=$publish_id;";
$res = mysqli_query($sql->getConn(), $query);
if ($res) {
    $rr->send(0, 'success', []);
} else {
    $log->error("task@view failed to excute sql update:" . $query . "|" . "code:" . mysqli_errno($sql->getConn()) . "|" . "msg:" . mysqli_error($sql->getConn()));

}
$rr->send(0, 'success', []);
