<?php

namespace GetTreeRepository;

require_once __DIR__.'/../vendor/autoload.php';

use GetTreeRepository\FileReader;
use GetTreeRepository\ComposerReader;

class PackageExplorer
{
    protected $package;

  //  public function __construct($property)
  //  {
  //      $this->property = $property;
  //  }


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

$composerReader->getPropertySchema('require');

$dependency = $composerReader->getAttrArray('require');
$repositories = $composerReader->getAttrArray('repositories');

var_dump($dependency);
var_dump($repositories);

$masterRepository = 'fabiosan75';

$treePkgArray = $composerReader->getTreePkgSchema($masterRepository);

print_r($treePkgArray);

