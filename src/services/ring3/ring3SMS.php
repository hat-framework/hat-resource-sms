<?php

namespace services\ring3;
class ring3SMS extends \classes\baseSMS implements \classes\smsInterface{
    
    public function __construct() {
        if(!function_exists('curl_init')){
            die("Atenção ative o CURL para poder enviar SMS");
            //return false;
        }
    }
    
    private function getUrl($mensagem, $telefone){
        $remetente  = substr(SITE_NOME, 0, 10);
        return(str_replace(
            array('{%email3ring%}', '{%senharing%}', '{%numero%}', '{%mensagem%}', '{%remetente%}'), 
            array(SMS_EMAIL3RING, SMS_SENHA3RING, $telefone, $mensagem, $remetente), 
            SMS_BASE_URL3RING
        ));
    }
    
    private function response($res){
        $res = trim($res);
        if($res == "ok"){
            $this->setMessage(true, "Mensagem enviada com Sucesso!");
            return true;
        }
        
        if($res != "") $this->setMessage(false, "Erro: $res");
        else           $this->setMessage(false, "O servidor da 3Ring não enviou uma mensagem de callback!");
        return false;
    }
    
    public function sendSms($telefone, $mensagem){
        $mensagem = $this->shortMessage($mensagem);
        $telefone = $this->filtherPhone($telefone);
        $url      = $this->getUrl($mensagem, $telefone);
        $res      = simple_curl($url);
        return $this->response($res);
    }
    
}