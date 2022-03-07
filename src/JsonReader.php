<?php

namespace GetTreeRepository;

use GetTreeRepository\Interfaces\JsonReaderInterface;
use GetTreeRepository\Interfaces\FileReaderInterface;

/**
 * Class JsonReader : Implementa los metodos para el acceso al FileSystem
 * 
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class JsonReader implements JsonReaderInterface
{
    /**
     * @var string
     */
    
    private $_filename;

    private $fileReader;
    
    /**
     * Method __construct
     *
     * @param ( $schema [explicite description]
     *
     * @return void
     */

    public function __construct(FileReaderInterface $fileReader,string $filePath )
    {
        $this->fileReader = $fileReader;
        $this->_filePath = $filePath;

    }

    public function getContent(string $filename): string
    {
        return $this->fileReader->readfile($this->_filePath);
    }

}
