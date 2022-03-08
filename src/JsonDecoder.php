<?php
/**
 * Class JsonDecoder : Implementa los metodos obtener la data del json file
 * 
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

/**
 * JsonDecoder
 */
class JsonDecoder implements JsonDecoderInterface
{

    private $fileReader;

    private $assoc;

    private $depth;

    private $options;
    
    private string $_jsonSchema;

    public $jsonReader;
    
    /**
     * Method __construct
     *
     * @param $filePath Ruta al archivo .json
     * 
     * @return void
     */
    public function __construct(string $filePath,FileReaderInterface $reader ) 
    {
        $this->filePath = $filePath;
        $this->fileReader = $reader;// $fileReader;
    //    $this->assoc   = $assoc;
    //    $this->depth   = $depth;
    //    $this->options = $options;
        
    }
 
    /**
     * Method getContent Lee el contenido del archivo $_filepath 
     *
     * @return string
     */
    public function loadSchema(): array
    {
        $dataSchema = [];
        $this->_jsonSchema = $this->fileReader->readfile();

        if ($this->validateJsonFormat()) {
            $dataSchema = json_decode($this->_jsonSchema,true);

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
            json_decode($this->_jsonSchema);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }
    
}
