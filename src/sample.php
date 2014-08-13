<?php

require_once './autoload.php';
$php = new services\ring3\ring3SMS();
if(false === $php->sendSms("3194494408", "Seja bem vindo ao site!")){
    //tratamento de status false.
}
echo $php->getMessage();