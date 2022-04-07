<?php
/**
 * JsonReaderInterface
 *
 * PHP version 7
 *
 * @category Interface
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace RepositoryExplorer\Interfaces;

/**
 * Class JsonReaderInterface : Define los metodos para el acceso al FileSystem
 * 
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
interface JsonReaderInterface
{
    /**
     * Method getContent Retorna el contenido del archivo instanciado en $fileReader
     *
     * @param string $fileName Path/source al archivo json
     *
     * @return string
     */
    public function getContent(string $fileName): string;
    
}
