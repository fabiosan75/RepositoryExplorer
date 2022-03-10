<?php

namespace GetTreeRepository;

require_once __DIR__.'/../vendor/autoload.php';

use GetTreeRepository\ComposerReader;
use GetTreeRepository\PackageNode;

class PackageExplorer
{
    protected $package;

  /*  public $composerReaderI;

    public function __construct(ComposerReaderInterface $composerReader)
    {
        $this->composerReaderI = $composerReader;
    }
*/

}

$file = $argv[1];//'../../Proyecto1/composer.json';
//$file = '../../../libreria1/composer.json';

$masterRepository = 'fabiosan75'; // Vendor Name directorio que contiene el repositorio

/*
$reader = new FileReader($file);

$decoder = new JsonDecoder($reader);

$composerReader = new ComposerReader($decoder);
*/

$composerReader = new ComposerReader($file);

$packageNode = new PackageNode($composerReader);

$packageNode->setProperties();

$composerReader->getPropertySchema('require');

$dependency = $composerReader->getAttrArray('require');
$repositories = $composerReader->getAttrArray('repositories');

print_r($packageNode);
//var_dump($dependency);
//var_dump($repositories);

$masterRepository = 'fabiosan75';

//$treePkgArray = $composerReader->getTreePkgSchema($masterRepository);

//print_r($treePkgArray);

