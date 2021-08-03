<?php

namespace Validator;

use Service\UserService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{
    private $request;
    private $dadosRequest;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USER = 'USER';

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function processarRequest()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        $this->request['metodo'] == 'POST';
        
        if(in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST,true))
        {
            $retorno = $this->direcionarRequest();
        }
        var_dump($retorno); exit;
        return $retorno;
    }

    private function direcionarRequest()
    {
        if($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE )
        {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        }

        $metodo = $this->request['metodo'];

        return $this->$metodo();
    }

    private function get()
    {
        $retorno  = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET,true))
        {
           switch($this->request['rota'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $retorno = $UserService->validarGet();
                    echo "<pre>";
                    var_dump($retorno);exit;

           }
        }
    }
}