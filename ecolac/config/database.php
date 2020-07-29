<?php

class BaseConection {
   
    public static function Connect() {
        $db = new mysqli('localhost:3308', 'root', '', 'ecolacdb');
        //$db->query("SET NAMES 'utf8'");                       
        return $db;
    }
 
}
