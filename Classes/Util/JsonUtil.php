<?php

namespace Util;

use InvalidArgumentException;
use JsonException;

class JsonUtil
{
    public static function tratarCorpoRequisicaoJson()
    {

        try{
            $postJson =  json_decode(file_get_contents('php://input'), true);
        }catch(JsonException $e)
        {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
        }

        if(is_array($postJson) && count($postJson) > 0 )
        {
            return $postJson;
        }
        
    }

    public function processArray($return)
    {
        $data = [];
        $data[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;

        if(is_array($return) && count($return) > 0 || strlen($return) > 10)
        {
            $data[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
            $data[ConstantesGenericasUtil::RESPOSTA] = $return;
        }
        $this->toJson($data);
    }

    private function toJson($json)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store,must-revalidade');
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');

        echo json_encode($json);
        exit;
    }
}