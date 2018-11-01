<?php
/**
 * Created by PhpStorm.
 * User: SpringRain
 * Date: 2018/9/27
 * Time: 10:49
 */
namespace SQL;
class SQLHelper
{
    const HOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = '';
    const PORT = 3306;
    public $conn;
    function __construct()
    {
        $this->connect();
    }
    public function connect()
    {
        $conn = mysqli_connect(self::HOST, self::USER, self::PASSWORD);
        mysqli_select_db($conn,'community');
        mysqli_query($conn, "SET NAMES UTF-8");
        $this->conn = $conn;
    }
    public function getConn(){
        return $this->conn;
    }
    public function close()
    {
        mysqli_close($this->conn);
    }
    public function query($sql)
    {
    }
    public function select($sql)
    {
    }
    public function insert($sql)
    {
    }
}