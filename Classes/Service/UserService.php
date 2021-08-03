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

    private function getOneByKey()
    {

    }

    private function listar()
    {
        return $this->UserRepository->getMySQL()->getAll(self::TABLE);
    }
}