<?php
namespace SDQ\CrudManagement;
/**
* Interface IManagerCrud dont l'implémentation crée des classes répondant à une signature identique
*
* Permet d'uniformiser les méthodes de chaque implémentation et donc d'utiliser plus aisément et de façon plus intuitive ces dernières
*/
interface IManagerCrud
{
    public static function afficheTout(SourceDonnees $oSource);
    public static function chercheParClef(SourceDonnees $oSource, $clef);
    public static function chercheParChamps(SourceDonnees $oSource, array $aDonnees);
    public static function insereEnregistrement(SourceDonnees $oSource, array $aAttributs);
    public static function modifieEnregistrement(SourceDonnees $oSource, $clef, array $aNouveauxAttributs);
    public static function supprimeEnregistrement(SourceDonnees $oSource, $clef);
    public static function supprimeTout(SourceDonnees $oSource);

}
