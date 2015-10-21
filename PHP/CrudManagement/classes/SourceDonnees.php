<?php
namespace SDQ\CrudManagement;
/**
* Classe abstraite dont l'héritage fourni des éléments obligatoires aux classes filles
*
* En rendant des attributs obligatoires et en proposant des méthodes faciles à hériter cette classe permet de générer aisément un sous-ensemble concret répondant à une signature spécifique. Ceci permet donc d'assurer une utilisation uniformisée des classes filles
*/
abstract class SourceDonnees
{
    protected $_sNom;
    protected $_sClefPrimaire;
    protected $_aAttributs;

    public function getNom() {
        return $this->_sNom;
    }
    public function getClefPrimaire() {
        return $this->_sClefPrimaire;
    }
    public function getAttributs() {
        return $this->_aAttributs;
    }

    public function setNom($sNom) {
        $this->_sNom = $sNom;
    }
    public function setClefPrimaire($sClefPrimaire) {
        $this->_sClefPrimaire = $sClefPrimaire;
    }
    public function setAttributs($aAttributs) {
        $this->_aAttributs = $aAttributs;
    }

	public function __set($attribut, $value) { // Empêche la création d'attribut inexistant dans la classe SourceDonnees (ou filles)
		throw new \InvalidArgumentException('L\'attribut '.$attribut.' est inconnu et ne peut être créé');
    }
	
}
