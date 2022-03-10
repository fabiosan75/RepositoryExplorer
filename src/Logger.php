<?php

namespace GetTreeRepository;

/**
 * Logger
 */
class Logger
{   
    /**
     * Method Log almacena los mensaje de excepción en un archivo log.txt
     * si no existe el archivo lo crea.
     * 
     * @param $msg Cadena con el mensaje arrojado por la excepción
     *
     * @return void
     */
    static function msgLogger($msg) 
    {  
      
        $msg = date('d-m-Y H:i:s') . ': ' . $msg;  
        $file = fopen('./log.txt', 'a+');  
      
        fwrite($file, $msg . "\r\n");  
        fclose($file);  
    }  

}