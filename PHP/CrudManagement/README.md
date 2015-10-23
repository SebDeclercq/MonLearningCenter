# README
## Architecture et objectifs
Cette architecture logicielle permet de créer des instances de classe découlant
de l'interface de la classe abstraite "SourceDonnees" et de faire interagir le
programme client avec les différents supports de données (BDD, fichier CSV,...)
selon une écriture précise.

Celle-ci est construite selon l'interface "IManagerCrud" qui impose la présence
de 7 méthodes permettant d'agir directement dans les supports en entrée (selon
le mode CRUD : Create, Read, Update, Delete). Les classes implémentant
cette interface sont des classes statiques.

### L'interface IManagerCrud
IManagerCrud est une interface avec 7 méthodes. Leurs signatures doivent
être respectées par les classes l'implémentant.

Cet ensemble de classes concrètes et de l'interface est construit en respectant
les règles du *Design Pattern Strategy*, à savoir encapsuler chaque algorithme au
sein d'une même famille et de les rendre interchangeable au sein de cette
dernière. Ainsi, peu importe la classe implémentant IManagerCrud, elle répondra
aux méthodes attendues.

Actuellement, ces classes sont au nombre de trois :
- ManagerCrudSql
- ManageCrudCsv
- ManagerCrudExcel

Concernant ManagerCrudExcel, ce dernier se base sur la classe PHPExcel
(disponible sur : https://phpexcel.codeplex.com/). ManagerCrudExcel est une
classe "adaptée" dans le *Desin Pattern Adapter* : elle permet l'utilisation de
la signature de PHPExcel et de ses méthodes, tout en se conformant à l'interface
"IManagerCrud".

L'utilisation du Design Pattern Adapter se situe au niveau des méthodes
litFichier et ecritFichier de ManagerCrudExcel et fonctionne sur base de la
composition.

### L'interface SourceDonnees
L'interface de la classe abstraite SourceDonnees est quant à elle créée afin
de générer les différentes classes concrètes de format de données (fichier CSV,
 table SQL,...). Elle est constituée selon le *Design Pattern Factory Method* qui
permet d'instancier des objets concrets issus d'une classe abstraite qui sert
à en généraliser la structure.

Actuellement, ces classes sont au nombre de trois (et répondent aux classes
citées ci-dessus) :
- TableSql
- CSV
- Excel

## Exemple minimal de création de classe
### NouveauManagerCrud.php
```php
<?php
class NouveauManagerCrud implements IManagerCrud
{
    public static function afficheTout(SourceDonnees $oSource) {}
    public static function chercheParClef(SourceDonnees $oSource, $clef) {}
    public static function chercheParChamps(SourceDonnees $oSource, array $aDonnees) {}
    public static function insereEnregistrement(SourceDonnees $oSource, array $aAttributs) {}
    public static function modifieEnregistrement(SourceDonnees $oSource, $clef, array $aNouveauxAttributs) {}
    public static function supprimeEnregistrement(SourceDonnees $oSource, $clef) {}
    public static function supprimeTout(SourceDonnees $oSource) {}

}
```
### NouvelleSourceDonnees.php
```php
<?php
class NouvelleSourceDonnees extends SourceDonnees {}
```
## Exemple minimal d'instanciation
### Client.php
```php
<?php
$source = new NouvelleSourceDonnees;
$source->setAttributs('id', 'nom');

$element = ['id' => 'SDQ', 'nom' => 'Sébastien Declercq'];

$source->insereEnregistrement($element);

```
