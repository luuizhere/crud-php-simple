<?php

namespace Validator;

use InvalidArgumentException;
use Service\UserService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{
    private $request;
    private $dataRequest = [];

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USER = 'USER';

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function processarRequest()
    {
        $return = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        
        if(in_array($this->request['method'], ConstantesGenericasUtil::TIPO_REQUEST,true))
        {
            $return = $this->directRequest();
        }
        return $return;
    }

    private function directRequest()
    {
        if($this->request['method'] !== self::GET && $this->request['method'] !== self::DELETE )
        {
            $this->dataRequest = JsonUtil::bodyRequestJson();
        }

        $method = $this->request['method'];

        return $this->$method();
    }

    private function get()
    {
        $return  = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['route'], ConstantesGenericasUtil::TIPO_GET,true))
        {
           switch($this->request['route'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $return = $UserService->validateGet();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
           }
        }
        return $return;
    }

    
    private function delete()
    {
        $return  = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['route'], ConstantesGenericasUtil::TIPO_DELETE,true))
        {
           switch($this->request['route'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $return = $UserService->validateDelete();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
           }
        }
        return $return;
    }

    private function post()
    {
        $return  = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['route'], ConstantesGenericasUtil::TIPO_POST,true))
        {
           switch($this->request['route'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $UserService->setDataRequest($this->dataRequest);
                    $return = $UserService->validatePost();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
           }
        }
        return $return;
    }
}