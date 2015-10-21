<?php
namespace SDQ\CrudManagement;
include_once('ManagerCrudSql.php');

class TableSql extends SourceDonnees
{
    protected $_sHote;
    protected $_sBase;
    protected $_sId;
    protected $_sMdp;
    protected $_oPdo;

    public function __construct($sNomTable, array $aAttributs) {
        if (isset($sNomTable)) {
            $this->_sNom = $sNomTable;
        }
        if ( isset($aAttributs[0]) && isset($aAttributs[1])
            && isset($aAttributs[2]) && isset($aAttributs[3]) ) {
            $this->_sHote   = $aAttributs[0];
            $this->_sBase   = $aAttributs[1];
            $this->_sId     = $aAttributs[2];
            $this->_sMdp    = $aAttributs[3];
            $this->_oPdo    = new \PDO($this->_sHote.';dbname='.$this->_sBase, $this->_sId, $this->_sMdp);
        }
        else {
            throw new InvalidArgumentException('La classe TableSql attend en paramètre le nom de la table à utiliser et les informations de connexion à la base de données');
        }
    }

    public function getPdo() {
        return $this->_oPdo;
    }

    public function afficheTout() {
        ManagerCrudSql::afficheTout($this);
    }
    public function chercheParClef($clef) {
        ManagerCrudSql::chercheParClef($this, $clef);
    }
    public function chercheParChamps(array $aDonnees) {
        ManagerCrudSql::chercheParChamps($this, $aDonnees);
    }
    public function insereEnregistrement(array $aAttributs) {
        ManagerCrudSql::insereEnregistrement($this, $aAttributs);
    }
    public function modifieEnregistrement($clef, array $aNouveauxAttributs) {
        ManagerCrudSql::modifieEnregistrement($this, $clef, $aNouveauxAttributs);
    }
    public function supprimeEnregistrement($clef) {
        ManagerCrudSql::supprimeEnregistrement($this, $clef);
    }
    public function supprimeTout() {
        ManagerCrudSql::supprimeTout($this);
    }

}
