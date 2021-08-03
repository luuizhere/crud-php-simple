<?php
/**
 * AUTOLOAD DE CLASSES PARA O PACOTE 'Classes'
 * @param $class
 */
function autoload($class)
{
    $directoryBase = DIR_APP . DS;
    $class = $directoryBase . 'App' . DS . str_replace('\\', DS, $class) . '.php';
    if (file_exists($class) && !is_dir($class)) {
        include $class;
    }
}

spl_autoload_register('autoload');