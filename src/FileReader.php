<?php

namespace GetTreeRepository;

use GetTreeRepository\Interfaces\FileReaderInterface;

/**
 * FileReader : Implementa los metodos para el acceso al FileSystem
 * 
 * @category Class
 * @package  GetTreeRepository
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
     * @param string $filename [explicite description]
     *
     * @return void
     */
    public function __construct(string $filename)
    {
            $this->_fileName = $filename;       
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
        if (!$this->canReadFile($this->_fileName)) {
            throw new \RuntimeException("Error Lectura Archivo :". $this->_fileName);
        } else {
            return file_get_contents($this->_fileName);
        }
    
    }
    
}
