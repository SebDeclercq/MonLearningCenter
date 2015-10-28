<?php
namespace SDQ\CrudManagement;

class Excel extends SourceDonnees
{
    public function __construct($sNom=null) {
        if (isset($sNom)) {
            $this->_sNom = $sNom;
        }
    }

    public function afficheTout() {
        return ManagerCrudExcel::afficheTout($this);
    }
    public function chercheParClef($clef) {
        return ManagerCrudExcel::chercheParClef($this, $clef);
    }
    public function chercheParChamps(array $aDonnees) {
        return ManagerCrudExcel::chercheParChamps($this, $aDonnees);
    }
    public function insereEnregistrement(array $aAttributs) {
        return ManagerCrudExcel::insereEnregistrement($this, $aAttributs);
    }
    public function insereMultiple(array $aListeAttributs) {
        return ManagerCrudExcel::insereMultiple($this, $aListeAttributs);
    }
    public function modifieEnregistrement($clef, array $aNouveauxAttributs) {
        return ManagerCrudExcel::modifieEnregistrement($this, $clef, $aNouveauxAttributs);
    }
    public function supprimeEnregistrement($clef) {
        return ManagerCrudExcel::supprimeEnregistrement($this, $clef);
    }
    public function supprimeTout() {
        return ManagerCrudExcel::supprimeTout($this);
    }
    public function litAttributs() {
        $this->_aAttributs = ManagerCrudExcel::litAttributs($this);
        return $this->_aAttributs;
    }
}
