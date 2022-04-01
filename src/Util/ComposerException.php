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

/**
 * ComposerException Extencion class Exception para el manejo de mensajes de 
 *                   exception y log de metodos de lectura y procesamiento de 
 *                   composer.json SCHEMA
 *                      
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class ComposerException extends \Exception
{
    /**
     * Method jsonError
     *
     * @return void
     */
    public function jsonError() 
    {
        
        $errorMsg = 'json Error '
                .$this->getMessage()." in "
                .basename($this->getFile()).':'.$this->getLine();

        Logger::msgLogger($errorMsg);  

        echo $errorMsg.PHP_EOL;
        
    }
}
