<?php

require_once './defines/include.php';
if(!defined('SITE_NOME')){define('SITE_NOME', "HatLabs");}
spl_autoload_register(function ($nomeClasse) {
    $ds   = DIRECTORY_SEPARATOR;
    $file = str_replace(array('/', '\\', '//'), $ds, dirname(__FILE__) .'/'. str_replace("_", "/", $nomeClasse).".php");
    if (file_exists($file)) {
        $e = str_replace('SMS', '',end(explode("\\",$nomeClasse)))."Config";
        $file2 = str_replace(array("SMS", '/', '\\', '//'), array("Config",$ds,$ds,$ds), dirname(__FILE__) .'/'. str_replace("_", "/", $nomeClasse)).'.php';
        if(file_exists($file2)){require_once $file2;}
        require_once($file);
        return;
    }
});