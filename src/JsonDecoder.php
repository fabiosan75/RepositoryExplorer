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

namespace GetTreeRepository;

use GetTreeRepository\Interfaces\FileReaderInterface;
use GetTreeRepository\Interfaces\JsonDecoderInterface;
use GetTreeRepository\Util\ComposerException;

/**
 * Class JsonDecoder : Implementa los metodos para el acceso al FileSystem
 * 
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class JsonDecoder implements JsonDecoderInterface
{

    public $fileReader;
    
    private string $_jsonSchema;
    
    /**
     * Method __construct
     *
     * @param $reader Instancia FileReaderInterface para acceso al .json
     * 
     * @return void
     */
    public function __construct(FileReaderInterface $reader ) 
    {
        $this->fileReader = $reader;        
    }
 
    /**
     * Method loadSchema Lee el contenido del archivo instanciado en $fileReader
     *                   valida que sea un json bien "formado" y retorna un array
     *                   con el SCHEMA
     * 
     * @return array
     */
    public function loadSchema(): array
    {
        $dataSchema = [];

        $this->_jsonSchema = $this->fileReader->readfile();

        try {
            if ($this->validateJsonFormat()) {
                $dataSchema = json_decode($this->_jsonSchema, true);
            } else {
                throw new ComposerException(
                    "Formato Json Invalido "
                    .$this->fileReader->getFileName()
                );
            } 

        }
        catch (ComposerException $e) {  
                $e->jsonError();
        }

        return $dataSchema;

    }
    
    /**
     * Method getSchema
     *
     * @return string
     */
    public function getSchema(): string
    {
        return $this->_jsonSchema;
    }
    
    /**
     * Method validateJsonFormat
     * Valida que el formato del SCHEMA sea un JSON "bien" formado
     * 
     * @return bool
     */
    public function validateJsonFormat(): bool 
    {

        if (!empty($this->_jsonSchema)) {
            @json_decode($this->_jsonSchema);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        
        return false;
    }

}
