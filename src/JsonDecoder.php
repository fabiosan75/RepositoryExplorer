<?php

namespace GetTreeRepository;

use GetTreeRepository\Interfaces\FileReaderInterface;
use GetTreeRepository\Interfaces\JsonDecoderInterface;

/**
 * JsonDecoder
 */

class JsonDecoder implements JsonDecoderInterface
{
    private string $_filepath;
    /**
     * @var bool
     */
    private $_assoc;
    /**
     * @var int
     */
    private  $_depth;
    /**
     * @var string
     */
    private $_options;
    
    private $_jsonData;

    private string $_jsonSchema;

    public $jsonReader;
    
    
    /**
     * Method __construct
     *
     * @param ( $fileReader [explicite description]
     *
     * @return void
     */
    public function __construct(FileReaderInterface $fileReader,
        bool $assoc = false, 
        int $depth = 512, 
        string $options = JSON_BIGINT_AS_STRING){

        $this->fileReader = $fileReader;
        //  $this->filepath = $filepath;
        $this->_assoc   = $assoc;
        $this->_depth   = $depth;
        $this->_options = $options;
        
    }

 /*   public function __construct(FileReaderInterface $fileReader)
    {
        $this->fileReader = $fileReader;
       // $this->_options = $options;   
    }
   */ 
    /**
     * Method getContent Lee el contenido del archivo $_filepath 
     *
     * @return string
     */
    public function loadSchema(): void
    {
        $this->_jsonSchema = $this->fileReader->readfile();
    }

    public function getSchema(): string
    {
        return $this->_jsonSchema;
    }

    /**
     * Method loadSchema ELIMINAR
     *
     * @return void
     */
  //  public function loadSchema():void
  //  {

  //      $this->_jsonData = $this->getContent($this->fileReader->getFileName());

  //  }
    /**
     * Method decode
     * Valida que el formato del SCHEMA sea un JSON bien formado
     * 
     * @return array
     */
    public function validateJsonFormat(): bool 
    {

        if (!empty($this->_jsonSchema)) {
      
                      @json_decode($this->_jsonSchema);
                      return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

    public function decodeSchema()
    {
        try {
            return json_decode($this->_jsonSchema,$this->_assoc,$this->_depth, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $e->getMessage(); // like json_last_error_msg()
            $e->getCode(); // like json_last_error()
        }

    }


}
