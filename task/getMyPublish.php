<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 13:58
 */
require_once "../lib/RR.php";
require_once "../lib/Log.php";
require_once "../sql/SQLHelper.php";

$uid = $_POST['uid'] ?? 0;

$status = $_POST['status'] ?? -1;//0:空闲；1：已接受；2：已完成

$log = new \lib\Log();
$rr = new \lib\RR("task@getMyPublish");
$sql = new \SQL\SQLHelper();
$rr->recv($_POST);

if ($uid <= 0) {
    $rr->send(-1, "参数错误", $_POST);
}

if ($status == -1) {
    $query = "select * from task_publish_info where user_id='$uid';";
} else {
    $query = "select * from task_publish_info where user_id='$uid' and status=$status;";
}
$data = [];
$res = mysqli_query($sql->getConn(), $query);
if (mysqli_num_rows($res)) {
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
}

$rr->send(0, 'success', $data);
