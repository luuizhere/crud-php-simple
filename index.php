<?php

use Util\JsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try{
    $req = new RequestValidator(RotasUtil::getRotas());
    $retorno = $req->processarRequest();

    $JsonUtil = new JsonUtil();
    $JsonUtil->processArray($retorno);

}catch(Exception $e)
{
    echo $e->getMessage();
}