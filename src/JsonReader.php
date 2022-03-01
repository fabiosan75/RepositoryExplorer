<?php

namespace GetTreeRepository;

use JsonReaderInterface;
use FileReaderInterface;

/**
 * JsonReader
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

    public function __construct(FileReaderInterface $fileReader )
    {

      //  $this->_filename = $filename;
        $this->fileReader = $fileReader;
    
    }

    public function getContent(string $filename): string
    {
        return $this->fileReader->readfile($filename);
    }

}
