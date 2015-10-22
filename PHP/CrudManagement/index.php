<?php
namespace SDQ\CrudManagement;
require('classes/Autoloader.php');
Autoloader::register();

$csv = new Csv('test.csv',';');
$csv->setAttributs(['id','nom']);
$csv->setClefPrimaire('id');

$enreg1 = ['id' => 1, 'nom' => 'seb'];
$enreg2 = ['id' => 2, 'nom' => 'aline'];
$enreg3 = ['id' => 3, 'nom' => 'null'];
$csv->insereEnregistrement($enreg1);
$csv->insereEnregistrement($enreg2);
$csv->insereEnregistrement($enreg3);

$aAttr = ['hote', 'base', 'id', 'mdp'];
$sql = new TableSql('test', $aAttr);
$sql->setAttributs(['id','nom']);
$sql->setClefPrimaire('id');

$i = 4;
foreach ($csv->afficheTout() as $enreg) {
    $enreg['id'] = $i++;
    $sql->insereEnregistrement($enreg);
}

foreach ($sql->chercheParChamps(['nom' => 'null']) as $enreg) {
    $id = $enreg['id'];
    $sql->modifieEnregistrement($id, ['nom' => 'test']);
}

// $sql->supprimeTout();
// $csv->supprimeTout();
