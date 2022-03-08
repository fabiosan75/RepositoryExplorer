<?php

namespace GetTreeRepository;

require_once __DIR__.'/../vendor/autoload.php';

use GetTreeRepository\Interfaces\DirectoryReaderInterface;
use RuntimeException;

/**
* FileReader : Implementa los metodos para el acceso al FileSystem
* 
* @category Class
* @package  GetTreeRepository
* @author   fabiosan75 <fabiosan75@gmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     https://github.com/fabiosan75
*/
class DirectoryReader implements DirectoryReaderInterface 
{
    
    protected $_path;
    
    /**
    * Method __construct
    *
    * @param string $dirPath [explicite description]
    *
    * @return void
    */
    public function __construct(string $dirPath)
    {
        $this->path = $dirPath;       
    }
    
    /**
    * Method getPath
    *
    * @return string
    */
    public function getPath():string
    {
        return $this->_path;       
    }
    
    /**
    * Method listDirectory Retorna los direcotrios de un repositorio 
    * <$dirpath> que contienen un archivo especificado en $pattern
    * EJ : composer.json  >>  
    *
    * @param  string $dirPath Sorce del direcotrio a explorar
    * @param  string $pattern Patrón para filtrar los directorios listados
    *                         EJ : </(composer.json)/>
    * @return array
    */
    public function listDir( string $dirPath, string $pattern): array
    {
        
        $files = [];
        $dir = '';
        
      //  if (!is_dir($dirPath)) {
      //      return 0;
      //  }
        
        if ($dirresource = opendir($dirPath)) {
            
            while (($file = readdir($dirresource)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                
                $filePath = $dir . '/' . $file;
                
                if (is_dir($dirPath)) {
                    $files = array_merge($files, $this->listDir($filePath, $pattern));
                } else {
                    if (preg_match($pattern, $file)) {
                        $files[basename($dir)] = $file;
                    }
                    // array_push($files, $filepath);
                }
            }
            closedir($dirresource);
            
        } else {
            throw new RuntimeException('Erro de lectura DirPath'.$dirPath); 
        }
        
        return $files;
        
    }
    
}

$pathDir = $argv[1];

$dirReader = new DirectoryReader($pathDir); 
$files = $dirReader->listDir($pathDir, '/(composer.json)/');


print_r($files);
foreach ($files AS $dirName => $file) {
    echo $dirName . '=>' . $file . PHP_EOL;
}


