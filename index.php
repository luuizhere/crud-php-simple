<?php

use Util\JsonUtil;
use Util\RoutesUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try{
    $req = new RequestValidator(RoutesUtil::getRotas());
    $retorno = $req->processRequest();

    $JsonUtil = new JsonUtil();
    $JsonUtil->processArray($retorno);

}catch(Exception $e)
{
    echo $e->getMessage();
}