<?php

namespace GetTreeRepository;

require_once __DIR__.'/../vendor/autoload.php';

use GetTreeRepository\Interfaces\FileReaderInterface;
use GetTreeRepository\Interfaces\JsonDecoderInterface;

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

    private string $_file;
  //  private $composerSchema;
    private static $_fileContent;

    private $_dataSchema;
    public $jsonDecoder;
   
    /**
     * Method __construct
     *
     * @param $file $file Ruta al archivo [path/composer.json] a procesar
     *
     * @return void
     */
    public function __construct(JsonDecoderInterface $jsonDecoder)
    { 
        $this->jsonDecoder = $jsonDecoder;
        $this->jsonDecoder->loadSchema();
        $this->_dataSchema = $this->jsonDecoder->decodeSchema();   
            
    }
    
   // public function getComposerSchema()
   // {
   //     $this->jsonDecoder->loadSchema();
   // }

        /**
     * Method getPropertySchema
     *
     * @param array $jsonSchema array asociativo con la estrucra del SCHEMA
     * @param string $propertyName nombre de la propiedad o grupo de elementos a extraer
     *
     * @return array
     */
    public function getPropertySchema(string $propertyName)
    {
        if (isset($this->_dataSchema[$propertyName])) {
            return $this->_dataSchema[$propertyName];
        } else {
            throw new \InvalidArgumentException('NE Propiedad SCHEMA '.$propertyName);
        }

    }

    public function checkPkgName(string $pkgName): bool{

        if (empty($pkgName))
            return false;

        $pkgNameString = $this->getPropertySchema('name');

        if (empty($pkgNameString) || ($pkgNameString != $pkgName))
            return false;

    }

    public function getTreePkgSchema(string $masterRepository)
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

$file = '../../Proyecto1/composer.json';
//$file = '../../../libreria1/composer.json';

$masterRepository = 'fabiosan75'; // Vendor Name directorio que contiene el repositorio

//$composerMeta = array();


$reader = new FileReader($file);

$decoder = new JsonDecoder($reader, true);

//$contentschema = $composerdecoder->getContent();

$composerReader = new ComposerReader($decoder);


var_dump($composerReader);
//$composerreader->getComposerSchema();
//$composerReader->getJson(); 

//$treePkgArray = $composerreader->getComposerSchema();

$masterRepository = 'fabiosan75';
$treePkgArray = $composerReader->getTreePkgSchema($masterRepository);

print_r($treePkgArray);


?>