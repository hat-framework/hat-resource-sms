<?php

namespace classes;
class baseSMS{
    
    protected $login = '';
    protected $passwd = '';
    protected function setLogin($login){
        $this->login = $login;
    }
    
    protected function setPassword($passwd){
        $this->passwd = $passwd;
    }
    
    protected function shortMessage($msg, $size = 150){
        $mensagem = trim($msg);
        if(strlen($mensagem) > $size){
            $mensagem = strip_tags($mensagem, "<a>");
            if(strlen($mensagem) > $size){
                $mensagem = $this->Resume($mensagem, $size);
            }
        }
        return $mensagem;
    }
    
    protected function filtherPhone($telefone){
        return filter_var($telefone, FILTER_SANITIZE_NUMBER_INT);
    }
    
    protected function Resume($string, $max_lenght = 120){

        //garante um tamanho mínimo para a string
        if($max_lenght <= 0) $max_lenght = 120;

        //remove espaços extras, e tags html
        $string = str_replace(array("  ", "   ", "\n"), " ", trim(strip_tags($string)));

        //verifica se string é maior que o tamanho definido
        if (strlen($string) > $max_lenght) {  

           $i = 0;
           //enquanto não encontrar um espaço em branco
           while (substr($string,$max_lenght,1) <> ' ' && ($max_lenght < strlen($string))){
                $i++; $max_lenght++;

                //se em 20 caracteres ainda não encontrou espaco em branco então retorna a string cortada mesmo..
                if($i == 20){
                    $max_lenght -= 20;
                    break;
                }
           };
        };

        if($max_lenght < 0) $max_lenght = 120;
        return substr($string,0,$max_lenght);  
     }
     
     protected function simple_curl($url,$post=array(),$get=array()){
	$url = explode('?',$url,2);
	if(count($url)===2){
            $temp_get = array();
            parse_str($url[1],$temp_get);
            $get = array_merge($get,$temp_get);
	}

	$ch = curl_init($url[0]."?".http_build_query($get));
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec ($ch);
    }
    
    private $msg_response_gatway = "";
    private $status_gatway = true;
    protected function setMessage($status, $msg){
        $this->status = $status;
        $this->msg_response_gatway = $msg;
    }
    
    public function getMessage(){
        return $this->msg_response_gatway;
    }
    
    public function getStatus(){
        return $this->status;
    }
}