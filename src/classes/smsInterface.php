<?php

namespace classes;
interface smsInterface{
    public function sendSms($telefone, $mensagem);
}