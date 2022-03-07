<?php

namespace GetTreeRepository;

use FileSystemReaderInterface;

/**
* FileSystem
*/
class DirectoryReader implements DirectoryReaderInterface 
{
    
    protected $path;

    public function __construct(string $path)
    {
            $this->path = $filename;       
    }

    public function getPath():string
    {
            return $this->path;       
    }

    /**
    * Method listDirectory
    *
    * @param string $dirPath [explicite description]
    *
    * @return array
    */
    
    public function listDirectory( string $dirpath, string $pattern):array
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
        

    
}
