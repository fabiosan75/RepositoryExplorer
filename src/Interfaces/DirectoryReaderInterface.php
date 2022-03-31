<?php
/**
 * DirectoryReaderInterface
 *
 * PHP version 7
 *
 * @category Interface
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace GetTreeRepository\Interfaces;

/**
 * Interface DirectoryReaderInterface : Define los metodos para acceso al FileSystem
 * 
 * @category Interface
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

interface DirectoryReaderInterface
{
       
    /**
     * Method listDirectory Retorna los direcotrios de un repositorio 
     *                      <$dirpath> que contienen un archivo especificado 
     *                      en $pattern
     * EJ : composer.json  >>  
     *
     * @param string $pattern Patrón para filtrar los directorios listados
     *                        EJ : </(composer.json)/>
     * 
     * @return array
     */
    public function listDir(string $pattern):array;
    
    /**
     * Method getPath   Retorn src/Path al directorio instanciado en la clase
     *
     * @return string
     */
    public function getPath():string;
    
    /**
     * Method isReadable Valida si el $path es un directorio 
     *
     * @param $dirPath src/Path ruta del directorio a validar
     *
     * @return bool
     */
    public function isDirectory(string $dirPath): bool;
    
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
    public function show(array $listFiles): string;
 
}
