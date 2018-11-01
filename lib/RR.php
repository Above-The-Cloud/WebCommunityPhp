<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 11:50
 */

namespace lib;


class RR
{
    private $log;
    private $traceId;
    private $request;
    private $interface;

    public function __construct($interface='')
    {
        $this->interface=$interface;
        $this->log = new Log();
        $this->traceId = time().rand();
    }

    public function recv($request){
        $this->request = $request;
        $this->log->info($this->interface."|request log|traceId:".$this->traceId."|"."params:".json_encode($request));
    }

    public function send($code=0, $msg='success', $data=[])
    {
        $res = ['code' => $code, 'msg' => $msg, 'data' => $data];
        $this->log->info($this->interface."|response log|traceId:".$this->traceId."|"."return:".json_encode($res));
        echo json_encode($res);
        exit;
    }

    public function finish($code=0, $msg='success', $data=[])
    {
        $res = ['code' => $code, 'msg' => $msg, 'data' => $data];
        $this->log->info($this->interface."|response log|traceId:".$this->traceId."|"."return:".json_encode($res));
        echo json_encode($res);
        exit;
    }
}