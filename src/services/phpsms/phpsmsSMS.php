<?php

namespace services\phpsms;
class phpsmsSMS extends \classes\baseSMS implements \classes\smsInterface{
    
    public function __construct() {
        if(!function_exists('curl_init')){
            die("Atenção ative o CURL para poder enviar SMS");
        }
        $this->setLogin(SMS_EMAIL_PHPSMS);
        $this->setPassword(SMS_SENHA_PHPSMS);
    }
    
    
    /**
     * @author Thompson Moreira <thom@origin-webmasters.com.br>
     * @param mixed $telefone string or array with numbers
     * @param string $mensagem
     * @return bool
     */
    public function sendSms($telefone, $mensagem){
        $mensagem = $this->shortMessage($mensagem);
        $telefone = $this->filtherPhone($telefone);
        $post     = $this->getDados($telefone, $mensagem);
        $res      = $this->simple_curl(SMS_BASE_URL_PHPSMS, $post);
        return true;
    }
    
    private function getDados($celular, $msg){
        $ddd     = substr($celular, 0, 2);
        $celular = substr($celular, 2, strlen($celular)-1);
        return array(
            'strUsuario' => SMS_EMAIL_PHPSMS,
            'strSenha'   => SMS_SENHA_PHPSMS,
            'intDDD'     => $ddd,
            'intCelular' => $celular,
            'memMensagem'=> $msg,
            'url_retorno'=> SMS_BASE_URLRETORNO_PHPSMS,
        );
    }
    
}