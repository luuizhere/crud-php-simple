<?php

namespace Validator;

use InvalidArgumentException;
use Service\AddressService;
use Service\CityService;
use Service\StateService;
use Service\UserService;
use Util\ConstantsGenericsUtil;
use Util\JsonUtil;

class RequestValidator
{
    private $request;
    private $dataRequest = [];

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USER = 'USER';
    const STATE = 'STATE';
    const CITY = 'CITY';
    const ADDRESS = 'ADDRESS';

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function processRequest()
    {
        $return = utf8_encode(ConstantsGenericsUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['method'], ConstantsGenericsUtil::TIPO_REQUEST,true))
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
        $return  = utf8_encode(ConstantsGenericsUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['route'], ConstantsGenericsUtil::TIPO_GET,true))
        {
           switch($this->request['route'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $return = $UserService->validateGet();
                    break;
                case self::STATE :
                    $StateService = new StateService($this->request);
                    $return = $StateService->validateGet();
                    break;
                case self::CITY :
                    $CityService = new CityService($this->request);
                    $return = $CityService->validateGet();
                    break;
                case self::ADDRESS :
                    $AddressService = new AddressService($this->request);
                    $return = $AddressService->validateGet();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_RECURSO_INEXISTENTE);
           }
        }
        return $return;
    }

    
    private function delete()
    {
        $return  = utf8_encode(ConstantsGenericsUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['route'], ConstantsGenericsUtil::TIPO_DELETE,true))
        {
           switch($this->request['route'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $return = $UserService->validateDelete();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_RECURSO_INEXISTENTE);
           }
        }
        return $return;
    }

    private function post()
    {
        $return  = utf8_encode(ConstantsGenericsUtil::MSG_ERRO_TIPO_ROTA);

        if(in_array($this->request['route'], ConstantsGenericsUtil::TIPO_POST,true))
        {
           switch($this->request['route'])
           {
                case self::USER :
                    $UserService = new UserService($this->request);
                    $UserService->setDataRequest($this->dataRequest);
                    $return = $UserService->validatePost();
                    break;
                case self::STATE :
                    $StateService = new StateService($this->request);
                    $StateService->setDataRequest($this->dataRequest);
                    $return = $StateService->validatePost();
                    break;
                case self::CITY :
                    $CityService = new CityService($this->request);
                    $CityService->setDataRequest($this->dataRequest);
                    $return = $CityService->validatePost();
                    break;
                case self::ADDRESS :
                    $AddressService = new AddressService($this->request);
                    $AddressService->setDataRequest($this->dataRequest);
                    $return = $AddressService->validatePost();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_RECURSO_INEXISTENTE);
           }
        }
        return $return;
    }
}