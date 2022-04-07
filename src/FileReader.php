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

use RepositoryExplorer\Interfaces\FileReaderInterface;
use RepositoryExplorer\Util\FileSystemException;

/**
 * FileReader : Implementa los metodos para el acceso al FileSystem
 *              Lectura y validación de archivo.
 * 
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class FileReader implements FileReaderInterface
{
    
    private $_fileName;
    
    /**
     * Method __construct
     *
     * @param string $fileName src/Path al archivo
     *
     * @return void
     */
    public function __construct(string $fileName)
    {
            $this->_fileName = $fileName;       
    }
         
    /**
     * Method getFileName
     *
     * @return string
     */
    public function getFileName():string
    {
            return $this->_fileName;       
    }

    /**
     * Method canReadFile Valida si $_fileName es archivo y tiene permisos de lectura
     *
     * @return bool
     */
    public function canReadFile():bool
    {
        if (is_file($this->_fileName) && is_readable($this->_fileName) ) {
            return true;
        } else {
            return false;
        }
        
    }
         
    /**
     * Method readFile Lee y retorna el contenido del archivo $_fileName
     *
     * @return string
     */
    public function readFile():string 
    {
        try {
            if ($this->canReadFile($this->_fileName)) {
                return file_get_contents($this->_fileName);
            } else {
                throw new FileSystemException(
                    "Error Lectura Archivo :". $this->_fileName
                );
            }

        } catch (FileSystemException $e) {  
            echo $e->fsError();
            die("FileReader ERROR".PHP_EOL); 
        }
        
    }
    
}
