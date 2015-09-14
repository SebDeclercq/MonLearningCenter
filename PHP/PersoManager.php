<?php
class PersoManager
{
    // Variable contenant l'objet PDO
    private $_bdd;

    // Instancie PersoManager avec un objet PDO
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }
    public function setBdd(PDO $bdd) { $this->_bdd = $bdd; }

    // Fonctions CRUD (SQL : create read update delete)
    public function get($info) {
        if (is_int($info)) { // Si on cherche un chiffre -> id
            $q = $this->_bdd->query('SELECT id,nom,degats FROM Perso '.
                                    'WHERE id='.$info);
        }
        else { // Si on cherche une chaine => nom
            $q = $this->_bdd->query('SELECT id,nom,degats FROM Perso '.
                                    'WHERE nom="'.$info.'"');
        }
        return new Perso($q->fetch(PDO::FETCH_ASSOC));
    }

    public function cree(Perso $perso) {
        $sSql = 'INSERT INTO Perso (nom) VALUES ('.$perso->sNom.')';
        $this->_bdd->execute($sSql);

        $perso->hydrate(array(
            'iId' => $this->_bdd->lastInsertId(),
            'degats' => 0
        ));

    }
    public function modifie(Perso $perso) {

    }
    public function supprime(Perso $perso) {
        $sSql = 'DELETE FROM Perso WHERE id='.$perso->iId;
        return $_bdd->execute($sSql);
    }
}