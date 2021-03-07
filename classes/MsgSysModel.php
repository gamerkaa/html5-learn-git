<?php

require_once dirname(__FILE__) . "/Model.php";

class MsgSysModel extends Model {
    public function __construct() {
        $this->dbh = new PDO('mysql:host='. MSGSYS_DB_HOST . ';dbname='. MSGSYS_DB_NAME,MSGSYS_DB_USER,MSGSYS_DB_PASS);
    }
}