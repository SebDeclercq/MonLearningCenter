<?php
namespace SDQ\CrudManagement;

class Perinorm extends SourceDonnees
{
    protected $_sSeparateur;
    protected $_sSeparateurEnregistrement;
    protected $_sSeparateurOccurrence = '*';
    protected $_sFormat;

    public function __construct($sNom=null, $sFormat='Perinorm', $sSeparateur='@') {
        if (isset($sNom)) {
            $this->_sNom = $sNom;
        }
        $this->_sSeparateur = $sSeparateur;
        $aFormats = ['Perinorm', 'PeriPSM', 'LgPerinorm'];
        switch ($sFormat) {
            case $aFormats[0] :
                $this->_sSeparateurEnregistrement = '|';
                $this->_sFormat = $aFormats[0];
                break;
            case $aFormats[1] :
                $this->_sSeparateurEnregistrement = "\n";
                $this->_sFormat = $aFormats[1];
                break;
            case $aFormats[2] : {
                $this->_sSeparateurEnregistrement = "\n";
                $this->_sSeparateur = "\n";
                $this->_sFormat = $aFormats[2];
                break;
            }
            default :
                throw new \InvalidArgumentException('Le format "'.$sFormat.'" n\'existe pas');
        }
    }

    public function getFormat() {
        return $this->_sFormat;
    }
    public function getSeparateur() {
        return $this->_sSeparateur;
    }
    public function getSeparateurEnregistrement() {
        return $this->_sSeparateurEnregistrement;
    }
    public function getSeparateurOccurrence() {
        return $this->_sSeparateurOccurrence;
    }

    public function setSeparateur($sSeparateur) {
        $this->_sSeparateur = $sSeparateur;
    }
    public function setSeparateurOccurrence($sSeparateurOccurrence) {
        $this->_sSeparateurOccurrence = $sSeparateurOccurrence;
    }

    public function afficheTout() {
        return ManagerCrudPerinorm::afficheTout($this);
    }
    public function chercheParClef($clef) {
        return ManagerCrudPerinorm::chercheParClef($this, $clef);
    }
    public function chercheParChamps(array $aDonnees) {
        return ManagerCrudPerinorm::chercheParChamps($this, $aDonnees);
    }
    public function insereEnregistrement(array $aAttributs) {
        return ManagerCrudPerinorm::insereEnregistrement($this, $aAttributs);
    }
    public function insereMultiple(array $aListeAttributs) {
        return ManagerCrudPerinorm::insereMultiple($this, $aListeAttributs);
    }
    public function modifieEnregistrement($clef, array $aNouveauxAttributs) {
        return ManagerCrudPerinorm::modifieEnregistrement($this, $clef, $aNouveauxAttributs);
    }
    public function supprimeEnregistrement($clef) {
        return ManagerCrudPerinorm::supprimeEnregistrement($this, $clef);
    }
    public function supprimeTout() {
        return ManagerCrudPerinorm::supprimeTout($this);
    }
    public function litAttributs() {
        $this->_aAttributs = ManagerCrudPerinorm::litAttributs($this);
        return $this->_aAttributs;
    }
}
