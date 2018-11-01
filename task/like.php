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
$rr = new \lib\RR("task@like");
$sql = new \SQL\SQLHelper();
$rr->recv($_POST);

$data = [];

if ($uid <= 0 || $publish_id <= 0) {
    $rr->send(-1, "参数错误", $_POST);
}

$query = "update task_publish_info set liked=liked+1 where publish_id=$publish_id;";
$res = mysqli_query($sql->getConn(), $query);
if ($res) {
    $insert = "insert ignore into `like`(`uid`,`object_id`,`type`)values('$uid', $publish_id, 0);";
    $resInsert = mysqli_query($sql->getConn(), $insert);
    if ($resInsert) {
        $rr->send(0, 'success', $data);
    } else {
        $log->error("task@like failed to excute sql update:" . $insert . "|" . "code:" . mysqli_errno($sql->getConn()) . "|" . "msg:" . mysqli_error($sql->getConn()));
    }

} else {
    $log->error("task@like failed to excute sql update:" . $query . "|" . "code:" . mysqli_errno($sql->getConn()) . "|" . "msg:" . mysqli_error($sql->getConn()));
}
$rr->send(0, 'success', $data);
