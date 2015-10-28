<?php
namespace SDQ\CrudManagement;

class Csv extends SourceDonnees
{
    protected $_sSeparateur;

    public function __construct($sNom=null, $sSeparateur=';') {
        if (isset($sNom)) {
            $this->_sNom = $sNom;
        }
        $this->_sSeparateur = $sSeparateur;
    }

    public function getSeparateur() {
        return $this->_sSeparateur;
    }
    public function setSeparateur($sSeparateur) {
        $this->_sSeparateur = $sSeparateur;
    }

    public function afficheTout() {
        return ManagerCrudCsv::afficheTout($this);
    }
    public function chercheParClef($clef) {
        return ManagerCrudCsv::chercheParClef($this, $clef);
    }
    public function chercheParChamps(array $aDonnees) {
        return ManagerCrudCsv::chercheParChamps($this, $aDonnees);
    }
    public function insereEnregistrement(array $aAttributs) {
        return ManagerCrudCsv::insereEnregistrement($this, $aAttributs);
    }
    public function insereMultiple(array $aListeAttributs) {
        return ManagerCrudCsv::insereMultiple($this, $aListeAttributs);
    }
    public function modifieEnregistrement($clef, array $aNouveauxAttributs) {
        return ManagerCrudCsv::modifieEnregistrement($this, $clef, $aNouveauxAttributs);
    }
    public function supprimeEnregistrement($clef) {
        return ManagerCrudCsv::supprimeEnregistrement($this, $clef);
    }
    public function supprimeTout() {
        return ManagerCrudCsv::supprimeTout($this);
    }
    public function litAttributs() {
        $this->_aAttributs = ManagerCrudCsv::litAttributs($this);
        return $this->_aAttributs;
    }

}
