<?php

use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';




try{
    $req = new RequestValidator(RotasUtil::getRotas());
    $retorno = $req->processarRequest();
}catch(Exception $e)
{
    echo $e->getMessage();
}