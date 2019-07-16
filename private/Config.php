<?php

class Config{
    public $DB_NOME = "financeiro";
    public $DB_USR = "root";
    public $DB_SEN = "adsse12556";
    public $DB_LINK = "localhost";    
    public static $debug_into_db = false;
    public static $log_lvl = 2;
}

    function logMsg($text){
        if(Config::$debug_into_db){

        } else {
            $file = fopen(PVT.DS."log.ini", 'a');
            fwrite($file, $text. ". Data: ". date('d/m/Y H:i'). "\n");
            fclose($file);
        }
    }