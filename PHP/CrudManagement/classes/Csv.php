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
        ManagerCrudCsv::afficheTout($this);
    }
    public function chercheParClef($clef) {
        ManagerCrudCsv::chercheParClef($this, $clef);
    }
    public function chercheParChamps(array $aDonnees) {
        ManagerCrudCsv::chercheParChamps($this, $aDonnees);
    }
    public function insereEnregistrement(array $aAttributs) {
        ManagerCrudCsv::insereEnregistrement($this, $aAttributs);
    }
    public function modifieEnregistrement($clef, array $aNouveauxAttributs) {
        ManagerCrudCsv::modifieEnregistrement($this, $clef, $aNouveauxAttributs);
    }
    public function supprimeEnregistrement($clef) {
        ManagerCrudCsv::supprimeEnregistrement($this, $clef);
    }
    public function supprimeTout() {
        ManagerCrudCsv::supprimeTout($this);
    }

}
