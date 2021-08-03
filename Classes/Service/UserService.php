<?php

namespace Service;

use InvalidArgumentException;
use Repository\UserRepository;
use Util\ConstantsGenericsUtil;

class UserService
{
    private array $datas;

    public const TABLE = 'users';
    public const RECURSOS_GET = ['list'];
    public const RECURSOS_DELETE = ['delete'];
    public const RECURSOS_POST = ['create'];

    private object $UserRepository;
    private $dataRequest = [];

    public function __construct($datas = [])
    {
        $this->datas = $datas;
        $this->UserRepository = new UserRepository();
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
        return $this->UserRepository->getMySQL()->getOneByKey(self::TABLE,$this->datas['id']);
    }

    private function list()
    {
        return $this->UserRepository->getMySQL()->getAll(self::TABLE);
    }

    private function delete()
    {
        return $this->UserRepository->getMySQL()->delete(self::TABLE,$this->datas['id']);
    }

    private function create()
    {
        [$name, $address] = [$this->dataRequest['name'], $this->dataRequest['address_id']];

        if ($name && $address) {
            if ($this->UserRepository->getRegisterByName($name) > 0) {
                throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_LOGIN_EXISTENTE);
            }

            if ($this->UserRepository->insertUser($name, $address) > 0) {
                $idInserido = $this->UserRepository->getMySQL()->getDb()->lastInsertId();
                $this->UserRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idInserido];
            }

            $this->UsuariosRepository->getMySQL()->getDb()->rollBack();

            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);

    }

    

    
}