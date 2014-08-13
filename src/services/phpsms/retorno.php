<?php

$ddd = $_GET['ddd'];
$celular = $_GET['celular'];
$mensagem = $_GET['mensagem'];

echo "Você acaba de enviar uma mensagem para o celular (".$ddd.") ".$celular ."<br>";
echo "A mensagem foi: ".$mensagem;