<?php

namespace Util;

class RoutesUtil
{
    public static function getRotas()
    {
        $urls = self::getUrls();
        $request = [];
        $request['route'] = strtoupper($urls[0]);
        $request['resource'] = $urls[1] ?? null;
        $request['id'] = $urls[2] ?? null;
        $request['method'] = $_SERVER['REQUEST_METHOD'];
        return $request;
    }

    public static function getUrls()
    {
        $uri = str_replace('/'.DIR_PROJETO, '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri,'/'));
    }
}