<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 2:53
 */
require_once "../lib/RR.php";
require_once "../lib/Log.php";
require_once "../sql/SQLHelper.php";

$uid = $_POST['uid'] ?? 0;
$publish_id = $_POST['publish_id'] ?? 0;
$status = $_POST['status'] ?? -1;//0:空闲；1：已接受；2：已完成

$log = new \lib\Log();
$rr = new \lib\RR();
$rr->recv($_POST);

if ($uid <= 0 || $publish_id <= 0 || $status <= -1) {
    $rr->send(-1, "参数错误", $_POST);
}

$sql = new \SQL\SQLHelper();
$query = "select * from task_publish_info where publish_id=$publish_id;";
$res = mysqli_query($sql->getConn(), $query);
if (mysqli_num_rows($res) > 0) {
    while ($row = $res->fetch_assoc()) {
        $currentStatus = $row['status'];
    }
} else {
    $rr->send(-2, "该资源不存在", ["publish_id" => $publish_id]);
}

$query = "select * from accept where publish_id=$publish_id and status<>0;";
$res = mysqli_query($sql->getConn(), $query);
if (mysqli_num_rows($res) > 0) {
    while ($row = $res->fetch_assoc()) {
        $acceptUid = $row['uid'];
        break;
    }
    if ($uid != $acceptUid) {
        $rr->send(-3, "操作无效", ["currentStatus" => $currentStatus, "acceptUid" => $acceptUid]);
    }
}


$update = "update task_publish_info set status=$status where publish_id=$publish_id;";
$resUpdate = mysqli_query($sql->getConn(), $update);
if ($resUpdate) {
    $queryAccept = "insert into accept(uid,publish_id,status)values('" . $uid . "',$publish_id,$status) on duplicate key update status=$status;";
    $res = mysqli_query($sql->getConn(), $queryAccept);
    if ($res) {
        $rr->send(0, "success", []);
    } else {
        $log->error("task@accept failed to excute sql insert:" . $queryAccept . "|" . "code:" . mysqli_errno($sql->getConn()) . "|" . "msg:" . mysqli_error($sql->getConn()));
    }
}
$rr->send(0, "success", []);
