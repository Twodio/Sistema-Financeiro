<?php


    define("DEBUG", true);
    define("DS", DIRECTORY_SEPARATOR);
    define("PVT", __DIR__);
    define("BEAN", PVT.DS."bean".DS);
    define("IMPORTS", PVT.DS."imports".DS);
    define("MODULOS", PVT.DS."modulos".DS);
    define("TPL", PVT.DS."template".DS);
    define("TPLA", PVT.DS."template".DS."admin".DS);
    define("TPLCAD", PVT.DS."template".DS."cad".DS);
    define("LOG", PVT.DS."log".DS);
    define("LOCAL", PVT.DS."local".DS);    
    
    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    require_once 'Config.php';
    require_once LOCAL.'strings.php';
    
    function auto_load($nomeClasse) {
        $dirs = array(MODULOS, IMPORTS, BEAN);
        
        foreach($dirs as $dir) {
            if(file_exists($dir.$nomeClasse.".class.php")) {
                require_once($dir.$nomeClasse.".class.php");
            }
        }
    }
    spl_autoload_register("auto_load");