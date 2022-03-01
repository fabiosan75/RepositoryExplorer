<?php

namespace GetTreeRepository;

use JsonDecoderInterface;
use JsonReader;

/**
 * JsonReader
 */

class JsonDecoder implements JsonDecoderInterface
{
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
    
    private string $_jsonData;

    private JsonReaderInterface $jsonReader;
    /**
     * Method __construct
     *
     * @param ( $schema [explicite description]
     *
     * @return void
     */

    public function __construct(JsonReaderInterface $jsonReader, bool $assoc = false, 
        int $depth = 512, 
        string $options = JSON_BIGINT_AS_STRING){

        $this->jsonReader = $jsonReader;
        $this->_assoc   = $assoc;
        $this->_depth   = $depth;
        $this->_options = $options;
        
    }

    public function loadSchema(string $filename):void
    {

        $this->_jsonData = $this->jsonReader->getContent($filename);

    }
    /**
     * Method decode
     * Obtiene el contenido del archivo composer.json y retorna el SCHEMA en un array
     * asocitivo
     * 
     * @return array
     */

    public function decode($schema):array
    {

        try {
            $this->_jsonData = json_decode($schema, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $e->getMessage(); // like json_last_error_msg()
            $e->getCode(); // like json_last_error()
        }

    }

    /**
     * Method getPropertySchema
     *
     * @param array $jsonSchema array asociativo con la estrucra del SCHEMA
     * @param string $propertyName nombre de la propiedad o grupo de elementos a extraer
     *
     * @return array
     */
    public function getPropertySchema(string $propertyName):string
    {
        if (isset($this->_jsonData[$propertyName])) {
            return $this->_jsonData[$propertyName];
        } else {
            throw new \InvalidArgumentException('NE Propiedad SCHEMA '.$propertyName);
        }

    }


}
