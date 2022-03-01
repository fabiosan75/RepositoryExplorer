<?php

namespace GetTreeRepository;

use FileSystemReaderInterface;

/**
* FileSystem
*/
class FileSystem implements FileSystemReaderInterface 
{
    

    /**
    * Method listDirectory
    *
    * @param string $dirPath [explicite description]
    *
    * @return array
    */
    public static function listDirectory( string $dirpath, string $pattern):array
    {
        
        $files = [];
        $dir = '';
        
        $dirresource = opendir($dirpath);
        
        while (($file = readdir($dirresource)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            
            $filepath = $dir . '/' . $file;
            
            if (is_dir($filepath))
            $files = array_merge($files, listdir($filepath, $pattern));
            else {
                if (preg_match($pattern, $file))
                $files[basename($dir)] = $file;
                // array_push($files, $filepath);
            }
        }
        closedir($dirresource);
        
        return $files;
        
    }
        
    /**
     * Method canReadFile Valida si $filename es archivo y tiene permisos de lectura
     *
     * @param string $filename [Nombre de Archivo a validar con su PATH <src>\name]
     *
     * @return bool
     */
    public static function canReadFile(string $filename):bool
    {
        if (is_file($filename) && is_readable($filename)) {
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
