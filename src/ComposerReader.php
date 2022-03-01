<?php

namespace GetTreeRepository;


use GetTreeRepository\FileSystemReader;
use GetTreeRepository\JsonDecoderInterface;

/**
 * Template File Doc Comment
 *
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 *
 */

/**
 * Template Class Doc Comment
 *
 * ComposerReader Class
 * ComposerReader : Implementa los metodos necesarios para leer elementos de
 * archivos composer.json y obtener propiedades de su SCHEMA 
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 *
 */


class ComposerReader
{

    private string $file;
  //  private $composerSchema;
    private static string $_fileContent;
    private public $jsonDecoder;
    /**
     * Method __construct
     *
     * @param $file $file Ruta al archivo [path/composer.json] a procesar
     *
     * @return void
     */
    public function __construct(string $file,JsonDecoderInterface $jsonDecoder)
    {
        if(empty($file)
            throw new \Exception("ERROR Nombre File {$file}");
      
            $this->file = $file;
            $this->jsonDecoder = $jsonDecoder;
    }
    
    public function loadSchema():string{

        $this->jsonDecoder->
    }
    public function checkPkgName(string $pkgName): bool{

        if (empty($pkgName))
            return false;

        $pkgNameString = $this->jsonDecoder->getPropertySchema('name');

        if (empty($pkgNameString) || ($pkgNameString != $pkgName))
            return false;

    }



    public function getTreePkgSchema(string $masterRepository): array
    {
        $treeRepositoryArray = array();

        $requireArray = $this->getPropertySchema('require');

        $pkgNameString = $this->getPropertySchema('name');

        $pkgTypeString = $this->getPropertySchema('type');

        if (count($requireArray) != 0) {

            foreach ($requireArray as $pkgNameString => $pkgVersionString) {

                list($vendorNameString,$projectNameString) = array_pad(explode('/', $pkgNameString), 2, null);
            
                if ($masterRepository === $vendorNameString) {
                    $treeRepositoryArray[$projectNameString] = array(
                        "type" => $pkgTypeString,
                        "name" => $vendorNameString,
                        "version" => $pkgVersionString);
                }
            }
        }
        return $treeRepositoryArray;

    } // End method getTreePkgSchema

}

$file = '../../../Proyecto1/composer.json';
//$file = '../../../libreria1/composer.json';

$masterRepository = 'fabiosan75'; // Vendor Name directorio que contiene el repositorio

//$composerMeta = array();

$composerReader = new ComposerReader($file);
var_dump($composerReader);
$composerReader->readFile();
$composerReader->getJson(); 

$treePkgArray = $composerReader->getTreePkgSchema($masterRepository);

print_r($treePkgArray);


?>