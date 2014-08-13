<?php

class smsResource extends \classes\Interfaces\resource{
      
    /**
    * Construtor da classe
    * @uses Carregar os arquivos necessários para o funcionamento do recurso
    * @throws DBException
    */
    public function __construct() {
        $this->dir = dirname(__FILE__);
        $this->loadClass();
    }
    
    /**
    * retorna a instância do smsSender
    * @uses Faz a chamada do contrutor
    * @return retorna um objeto com a instância
    */
    private static $instance = NULL;
    public static function getInstanceOf(){
        $class_name = __CLASS__;
        if (!isset(self::$instance))self::$instance = new $class_name;
        return self::$instance;
    }

    /*
     * Seta qual o serviço de envios será usado. O padrão é o 3 ring
     * Para adicionar novos serviços adicione uma classe na pasta services com
     * o nome do serviço a ser usado
     */
    private $service = "ring3";
    public function setService($service){
        $this->service = $service;
        $this->loadClass();
        return $this;
    }
    
    private $obj;
    private function loadClass(){
        $class = "{$this->service}SMS";
        $this->LoadResourceFile("services/$this->service/$class.php");
        if(!class_exists($class, false)){
            $this->setErrorMessage("O serviço de envio $this->service não está disponível ou não foi implementado!");
            return false;
        }
        $this->obj = new $class();
    }
    
    /*
     * Envia o sms utilizando o serviço escolhido
     */
    public function sendSms($numTelefone, $mensagem){
        die("$numTelefone - $mensagem");
        if(!$this->obj->sendSms($numTelefone, $mensagem)){
            $this->setMessages($this->obj->getMessages());
            return false;
        }
        $this->setSuccessMessage("SMS enviado corretamente para o número $numTelefone!");
        return true;
    }
}