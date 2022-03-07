<?php

namespace GetTreeRepository;

/**
 * FileSystemInterface
 */

interface FileSystemReaderInterface
{
       
    /**
     * Method listDirectory
     *
     * @param string $dirPath [explicite description]
     *
     * @return array
     */

    public static function listDirectory( string $dirpath,string $pattern):array; 
 
}
