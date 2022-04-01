<?php
/**
 * FileReaderInterface
 *
 * PHP version 7
 *
 * @category Interface
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace GetTreeRepository\Interfaces;

/**
 * FileReaderInterface : Denine los metodos para el acceso al FileSystem
 *                       Lectura y validación de archivo.
 * 
 * @category Interface
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
interface FileReaderInterface
{
        
    /**
     * Method getFileName 
     *
     * @return string
     */
    public function getFileName():string;
    
    /**
     * Method canReadFile Valida que el archivo existe y tenga permisos de lectura
     *
     * @return bool
     */
    public function canReadFile():bool;
    
    /**
     * Method readFile Retorna el contenido del archivo 
     *
     * @return string
     */
    public function readFile(): string;

}
