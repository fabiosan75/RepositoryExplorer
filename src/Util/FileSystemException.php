<?php
/**
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
namespace GetTreeRepository\Util;

use GetTreeRepository\Util\Logger;
use GetTreeRepository\Util\CliMsg;
use Exception;

/**
 * FileSystemException Extencion class Exception para el manejo de mensajes de 
 *                     exception y log de metodos de lectura y acceso al FileSystem
 *                      
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class FileSystemException extends Exception
{
    /**
     * Method Error
     *
     * @return void
     */
    public function fsError() 
    {
        
        $errorMsg = 'FileSystem Error '
                .$this->getMessage()." in "
                .basename($this->getFile()).':'.$this->getLine();

        Logger::msgLogger($errorMsg);  

        echo CliMsg::colorText($errorMsg, CliMsg::RED_TXTCOD).PHP_EOL; 

        exit;
    }
}
