<?php
/**
 * PHP version 7
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
namespace RepositoryExplorer\Util;

/**
 * Logger   Almacena los mensaje de excepción/errores en un archivo log.txt
 *          si no existe el archivo lo crea. Implementado como alternativa 
 *          sencilla para no incluir vendores como monolog y otros, pero extendible
 *          a manejadores de LOGs formales.
 *                      
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class Logger
{
    /**
     * Method msgLogger almacena los mensaje de excepción en un archivo log.txt
     *                  si no existe el archivo lo crea, no valida permisos sobre
     *                  el direcotrio, lo crea en src/Path del @package
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