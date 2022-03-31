<?php
/**
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
namespace GetTreeRepository;

use GetTreeRepository\Interfaces\DirectoryReaderInterface;
use GetTreeRepository\Util\FileSystemException;

/**
 * DirectoryReader : Implementa los metodos para el acceso al FileSystem y
 *                   obtener lista de archivos 
 * 
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class DirectoryReader implements DirectoryReaderInterface
{
    
    protected $path;
    
    /**
     * Method __construct
     *
     * @param string $dirPath src / PATH al directorio a leer
     *
     * @return void
     */
    public function __construct(string $dirPath)
    {  
        try {
            if (!$this->isDirectory($dirPath)) {
                throw new FileSystemException('Directorio '.$dirPath.' No Valido');
            } else {
                $this->path = $dirPath;
            }
        
        } catch (FileSystemException $e) {
            $e->fsError();
        }
    }
    
    /**
     * Method getPath   Retorn src/Path al directorio instanciado en la clase
     *
     * @return string
     */
    public function getPath():string
    {
        return $this->path;       
    }
    
    /**
     * Method isReadable Valida si el $path es un directorio 
     *
     * @param $dirPath src/Path ruta del directorio a validar
     *
     * @return bool
     */
    public function isDirectory(string $dirPath): bool
    { 
        return is_dir($dirPath);
    }
    
    /**
     * Method listDir Retorna los directorios de un repositorio 
     *                <$dirpath> que contienen un archivo especificado 
     *                en $pattern EJ : composer.json  >>  
     *
     * @param string $pattern Patrón para filtrar los directorios listados
     *                        EJ : </(composer.json)/>
     * 
     * @return array
     */
    public function listDir(string $pattern):array 
    {
        $files = [];
        $fh = opendir($this->path);

        while (($file = readdir($fh)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $filePath = $this->path . '/' . $file;

            if (is_dir($filePath) && file_exists($filePath.'/'.$pattern)) {
       
                $files[basename($filePath)] = $filePath.'/'.$pattern;
            }
        }

        closedir($fh);
        return $files;
    }
    
    /**
     * Method show Devuelve una cadena formateada con la lista de directorios
     * y archivos contenidos en $listFiles
     * 
     *  Ej :    GetTreeRepository =>  ..//GetTreeRepository/composer.json
     *                  Proyecto1 =>  ..//Proyecto1/composer.json
     *                  libreria2 =>  ..//libreria2/composer.json
     *                  libreria4 =>  ..//libreria4/composer.json
     *                  Proyecto2 =>  ..//Proyecto2/composer.json
     *
     * @param array $listFiles Array("Dir"=>"FileName")
     *
     * @return string
     */
    public function show(array $listFiles): string
    {
        $strLine = '';

        foreach ($listFiles AS $dirName => $file) {
            $strLine .= sprintf(" %25s =>  %-20s \n", $dirName, $file);
        }

        return $strLine;
    }

}

/*

Ejeplo uso Class

$pathDir = $argv[1];

$dirReader = new DirectoryReader($pathDir); 
$files = $dirReader->listDir('composer.json');
echo $dirReader->show($files);

**** Listar

//foreach ($files AS $dirName => $file) {
//    echo $dirName . ' => ' . $file . PHP_EOL;
//}

*/



