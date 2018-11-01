<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 23:16
 */

require_once "../lib/RR.php";
require_once "../lib/Log.php";
require_once "../sql/SQLHelper.php";

$uid = $_POST['uid'] ?? 0;

$log = new \lib\Log();
$rr = new \lib\RR("task@getLikeListByUid");
$sql = new \SQL\SQLHelper();
$rr->recv($_POST);

if ($uid <= 0) {
    $rr->send(-1, "参数错误", $_POST);
}
$data = [];
$query = "select * from `like` where `object_id` in (select `publish_id` as `object_id` from `task_publish_info` where `user_id`='$uid') order by ctime desc;";
$res = mysqli_query($sql->getConn(), $query);
if (mysqli_num_rows($res) > 0) {
    while ($row = $res->fetch_assoc()) {
        $dataRow = $row;
        $dataRow["publish_info"] = [];
        $dataRow["user_info"] = [];
        $publish_id = $dataRow['object_id'];
        $likeUid = $dataRow['uid'];

        $queryPublish = "select * from task_publish_info where publish_id=$publish_id;";
        $resPublish = mysqli_query($sql->getConn(), $queryPublish);
        if (mysqli_num_rows($resPublish) > 0) {
            $rowPublish = $resPublish->fetch_assoc();
            $dataRow["publish_info"] = $rowPublish;
        }

        $queryUser = "select user_id,user_name from user_info where user_id='$likeUid';";
        $resUser = mysqli_query($sql->getConn(), $queryUser);
        if (mysqli_num_rows($resUser) > 0) {
            $rowUser = $resUser->fetch_assoc();
            $dataRow["user_info"] = $rowUser;
        }
        $data[] = $dataRow;
    }

}
if (mysqli_errno($sql->getConn())) {
    $log->error("task@getLikeListByUid failed to excute sql update:" . $query . "|" . "code:" . mysqli_errno($sql->getConn()) . "|" . "msg:" . mysqli_error($sql->getConn()));

}
$rr->send(0, 'success', $data);
