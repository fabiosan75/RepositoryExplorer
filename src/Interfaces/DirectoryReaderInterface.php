<?php

namespace GetTreeRepository\Interfaces;

/**
 * FileSystemInterface
 */

interface DirectoryReaderInterface
{
       
    /**
     * Method listDir
     *
     * @param string $dirpath 
     * @param string $pattern 
     *
     * @return array
     */
    public function listDir( string $dirpath,string $pattern):array; 
 
}
