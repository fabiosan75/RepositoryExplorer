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
namespace RepositoryExplorer;

use RepositoryExplorer\Interfaces\JsonReaderInterface;
use RepositoryExplorer\Interfaces\FileReaderInterface;

/**
 * Class JsonReader : Implementa los metodos para el acceso al FileSystem
 * 
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class JsonReader implements JsonReaderInterface
{
    
    private $_filePath;
    public static $fileReader;
    
    /**
     * Method __construct
     *
     * @param FileReaderInterface $fileReader Clase para acceso al fileSystem
     * @param string              $filePath   src/Path archivo con json SCHEMA
     *
     * @return void
     */
    public function __construct(FileReaderInterface $fileReader,string $filePath )
    {
        $this->fileReader = $fileReader;
        $this->_filePath = $filePath;

    }
    
    /**
     * Method getContent Retorna el contenido del archivo instanciado en $fileReader
     *
     * @param string $fileName Path/source al archivo json
     *
     * @return string
     */
    public function getContent(string $fileName): string
    {
        return $this->fileReader->readfile($this->_filePath);
    }

}
