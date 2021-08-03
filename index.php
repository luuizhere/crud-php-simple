<?php

use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try{
    $req = new RequestValidator(RotasUtil::getRotas());
    $retorno = $req->processarRequest();

    var_dump($retorno);
}catch(Exception $e)
{
    echo $e->getMessage();
}