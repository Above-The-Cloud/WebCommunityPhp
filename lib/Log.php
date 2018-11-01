<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/11/1
 * Time: 10:16
 */

namespace lib;


class Log
{
    public $path = '../log';

    private $infoFileName;
    private $errorFileName;

    /**
     * Log constructor.
     * @param $msg
     * @param string $path
     */
    public function __construct()
    {

        //每天生成一个日志文件
        $filePath = $this->path . '/' . date('Y-m-d');

        if (!is_dir($filePath)) mkdir($filePath, 0777, true);

        //文件名
        $this->infoFileName = $filePath . '/' . 'info_' . date('Y-m-d') . '.log';
        $this->errorFileName = $filePath . '/' . 'error_' . date('Y-m-d') . '.log';

    }

    /**
     * @param $msg
     * @param string $path
     * @return bool
     */
    public function info($msg)
    {
        $prefix = date('Y-m-d H:i:s') . "[info]--";
        if (file_put_contents($this->infoFileName, $prefix . $msg . PHP_EOL, FILE_APPEND)) {
            return true;
        }
        return false;
    }

    public function debug($msg)
    {
        $prefix = date('Y-m-d H:i:s') . "[debug]--";
        if (file_put_contents($this->infoFileName, $prefix . $msg . PHP_EOL, FILE_APPEND)) {
            return true;
        }
        return false;
    }

    public function warning($msg)
    {
        $prefix = date('Y-m-d H:i:s') . "[warning]--";
        if (file_put_contents($this->errorFileName, $prefix . $msg . PHP_EOL, FILE_APPEND)) {
            return true;
        }
        return false;
    }

    public function error($msg)
    {
        $prefix = date('Y-m-d H:i:s') . "[error]--";
        if (file_put_contents($this->errorFileName, $prefix . $msg . PHP_EOL, FILE_APPEND)) {
            return true;
        }
        return false;
    }
}