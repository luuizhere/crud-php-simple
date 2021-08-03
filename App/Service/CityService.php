<?php

namespace Service;

use InvalidArgumentException;
use Repository\CityRepository;
use Util\ConstantsGenericsUtil;

class CityService
{
    private array $datas;

    public const TABLE = 'cities';
    public const RECURSOS_GET = ['list'];
    public const RECURSOS_DELETE = ['delete'];
    public const RECURSOS_POST = ['create'];

    private object $CityRepository;
    private $dataRequest = [];

    public function __construct($datas = [])
    {
        $this->datas = $datas;
        $this->CityRepository = new CityRepository();
    }

    public function validateGet()
    {
        $return = null;
        $resource = $this->datas['resource'];

        if(in_array($resource , self::RECURSOS_GET,true))
        {
            $return = $this->datas['id'] > 0 ? $this->getOneByKey() : $this->$resource();
        }else
        {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($return === null)
        {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_GENERICO);
        }

        return $return;
    }

    public function validateDelete()
    {
        $return = null;
        $resource = $this->datas['resource'];
        if(in_array($resource , self::RECURSOS_DELETE,true))
        {
            // $return = $this->datas['id'] > 0 ? $this->getOneByKey() : $this->$resource();
            if($this->datas['id'] > 0 )
            {
                $return = $this->$resource();
            }else
            {
                throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        }else
        {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($return === null)
        {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_GENERICO);
        }

        return $return;
    }

    public function validatePost()
    {
        $return = null;
        $resource = $this->datas['resource'];
        if(in_array($resource , self::RECURSOS_POST,true))
        {
           $return = $this->$resource();
        }else
        {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($return === null)
        {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_GENERICO);
        }

        return $return;
    }
    public function setDataRequest($dataRequest)
    {
        $this->dataRequest = $dataRequest;
    }

    private function getOneByKey()
    {
        return $this->CityRepository->getMySQL()->getOneByKey(self::TABLE,$this->datas['id']);
    }

    private function list()
    {
        return $this->CityRepository->getMySQL()->getAll(self::TABLE);
    }

    private function delete()
    {
        return $this->CityRepository->getMySQL()->delete(self::TABLE,$this->datas['id']);
    }

    private function create()
    {
        [$name, $state] = [$this->dataRequest['name'], $this->dataRequest['state_id']];

        if ($name && $state) {
            if ($this->CityRepository->getRegisterByName($name) > 0) {
                throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_LOGIN_EXISTENTE);
            }

            if ($this->CityRepository->insertName($name,$state) > 0) {
                $id = $this->CityRepository->getMySQL()->getDb()->lastInsertId();
                $this->CityRepository->getMySQL()->getDb()->commit();
                return ['ID' => $id];
            }

            $this->CityRepository->getMySQL()->getDb()->rollBack();

            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);

    }

    

    
}