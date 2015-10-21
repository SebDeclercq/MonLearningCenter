<?php
namespace SDQ\CrudManagement;
require('classes/Autoloader.php');
Autoloader::register();


$source = new TableSql('test', $aAttr);
$source->setAttributs(array('id','nom'));
$source->setClefPrimaire('id');


$attr1 = ['id'=>6, 'nom'=>'aline'];
$attr2 = ['id'=>7, 'nom'=>'seb'];
$attr3 = ['id'=>8, 'nom'=>'null'];
$source->insereEnregistrement($attr1);
$source->insereEnregistrement($attr2);
$source->insereEnregistrement($attr3);


// $source->supprimeEnregistrement(3);
// $source->modifieEnregistrement(3,array('nom'=>'Essai'));
