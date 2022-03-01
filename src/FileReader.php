<?php

namespace GetTreeRepository;

use FileReaderInterface;

/**
* FileSystem
*/
class FileSystem implements FileReaderInterface 
{
    
    private $_filename;
    
    /**
     * Method __construct
     *
     * @param string $filename [explicite description]
     *
     * @return void
     */

   // public function __construct(string $filename)
   // {
   //         $this->_filename = $filename;       
   // }
        
    /**
     * Method canReadFile Valida si $filename es archivo y tiene permisos de lectura
     *
     * @param string $filename [Nombre de Archivo a validar con su PATH <src>\name]
     *
     * @return bool
     */

    public static function canReadFile(string $filename):bool
    {
        if (is_file(string $filename) && is_readable(string $filename)) {
            return true;
        } else {
            return false;
        }
        
    }
         
    /**
     * Method readFile Lee y retorna el contenido de un archivo
     *
     * @param string $filename [explicite description]
     *
     * @return string
     */
    public function readFile( string $filename): string {

        if (!$this->canReadFile($filename)) {
            throw new \RuntimeException("Error Lectura Archivo :". $filename);
        } else {
            return file_get_contents($filename);
        }
    
    }
    
}
