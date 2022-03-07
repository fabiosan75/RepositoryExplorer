<?php

namespace GetTreeRepository\Interfaces;

/**
 * FileReaderInterface
 */
interface FileReaderInterface
{
        
    /**
     * Method getFileName 
     *
     * @return string
     */
    public function getFileName():string;
    
    /**
     * Method canReadFile Valida que el archivo existe y tenga permisos de lectura
     *
     * @return bool
     */
    public function canReadFile():bool;
    
    /**
     * Method readFile Retorna el contenido del archivo 
     *
     * @return string
     */
    public function readFile(): string;

}
