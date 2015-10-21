<?php
class Perso {
    /* Tous les attributs sont privés : permet des contrôles
     grâce aux setters (mutateurs) */
    private $_iId, $_sNom, $_iDegats;

    // Définition de constantes pour éviter le "code muet"
    const PERSO_BLESSE = 1;
    const PERSO_TUE    = 2;
    const C_EST_MOI    = 3;

    // Création des méthodes getters (accesseurs)
    public function iId()     { return $this->$_iId; }
    public function sNom()    { return $this->$_sNom; }
    public function iDegats() { return $this->$_iDegats; }

    // Création des méthodes setters (mutateurs)
    public function setsNom($sNom) {
        if (is_string($sNom)) {
            $this->_sNom = $sNom;
        }
    }
    public function setiDegats($iDegats) {
        if (is_int($iDegats) && $iDegats > 0 && $iDegats < 100) {
            $this->_iDegats = $iDegats;
        }
    }

    // Fonction pour hydrater l'objet
    public function hydrate(array $donnees) {
        foreach ($donnees as $attr=>$valeur) {
            if (method_exists($this, $methode)) {
                $this->{'set'.$attr}($value);
            }
        }
    }

    // Constructeur
    public function __construct(array $donnees) {
        $this->hydrate($donnees);
    }

    // Quand le perso en frappe un autre
    public function frappePerso(Perso $concurrent) {
        // On vérifie qu'on ne se frappe pas soi-même
        if ($concurrent->_iId == $this->_iId) {
            return C_EST_MOI;
        } else {
            return $concurrent->prendCoup();
        }
    }
    // l'autre perd 5 points
    public function prendCoup() {
        // S'il a moins de 95% de dégat, + 5%
        if ($this->_iDegats < 95) {
            $this->_iDegats += 5;
            return self::PERSO_BLESSE;
        }
        // S'il a 95% de dégat ou plus, arrive à 100% et meurt
        else {
            $this->_iDegats += $this->_iDegats;
            return self::PERSO_TUE;
        }
    }
}
