<?php

namespace Service;

use InvalidArgumentException;
use Repository\UserRepository;
use Util\ConstantesGenericasUtil;

class UserService
{
    private array $dados;

    public const TABLE = 'users';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_DELETE = ['delete'];

    private object $UserRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->UserRepository = new UserRepository();
    }

    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if(in_array($recurso , self::RECURSOS_GET,true))
        {
            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
        }else
        {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($retorno === null)
        {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarDelete()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if(in_array($recurso , self::RECURSOS_DELETE,true))
        {
            // $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
            if($this->dados['id'] > 0 )
            {
                $retorno = $this->$recurso();
            }else
            {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        }else
        {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if($retorno === null)
        {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    private function getOneByKey()
    {
        return $this->UserRepository->getMySQL()->getOneByKey(self::TABLE,$this->dados['id']);
    }

    private function listar()
    {
        return $this->UserRepository->getMySQL()->getAll(self::TABLE);
    }

    private function delete()
    {
        return $this->UserRepository->getMySQL()->delete(self::TABLE,$this->dados['id']);
    }
}