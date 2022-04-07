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

use RepositoryExplorer\Util\Logger;
use RepositoryExplorer\Util\CliMsg;

/**
 * CliException Extencion class Exception para el manejo de mensajes de exception
 *              y log de aplicación CLI
 *                      
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class CliException extends \Exception
{
    /**
     * Method jsonError
     *
     * @return void
     */
    public function cliError() 
    {
        
        $errorMsg = 'CLI Error '
                .' '.$this->getMessage().' in '
                .basename($this->getFile()).':'.$this->getLine();

        Logger::msgLogger($errorMsg);  

        echo CliMsg::colorText($errorMsg, CliMsg::RED_TXTCOD).PHP_EOL; 
       
    }
}
