<?php
namespace SDQ\CrudManagement;

class ManagerCrudSql implements IManagerCrud
{
    private function __construct() {} // Empêche l'instanciation de la "classe statique"
// C
    public static function insereEnregistrement(SourceDonnees $oSource, array $aAttributs) {
        $match = 0;
        foreach ($aAttributs as $sAttribut => $sValeur) {
            if (in_array($sAttribut, $oSource->getAttributs())) {
                $match++;
            }
        }

        $listeAttrs = implode(', ', $oSource->getAttributs());

        if ($match != count($oSource->getAttributs())) {
            throw new \InvalidArgumentException('Attribut(s) manquant(s). Attributs à insérer : '.$listeAttrs);
        }

        $sSql = 'INSERT INTO '.$oSource->getNom().' ('.$listeAttrs.') VALUES (';
        foreach ($oSource->getAttributs() as $sAttribut) {
            $sSql .= ':'.$sAttribut.', ';
        }
        $sSql = preg_replace('/(?>, )$/', ');', $sSql);

        $oPdoStatement = $oSource->getPdo()->prepare($sSql);

        foreach ($aAttributs as $sAttribut => $sValeur) {
            $oPdoStatement->bindValue(':'.$sAttribut, $sValeur);
        }

        try
        {
            $oPdoStatement->execute();
            return 1;
        }
        catch (\PDOException $e)
        {
            return $e->getMessage();
        }

    }
    public static function insereMultiple(SourceDonnees $oSource, array $aListeAttributs) {
        foreach ($aListeAttributs as $aAttributs) {
            self::insereEnregistrement($oSource, $aAttributs);
        }
    }
// R
    public static function afficheTout(SourceDonnees $oSource) {
        $sSql = 'SELECT * FROM '.$oSource->getNom();
        $oPdoStatement = $oSource->getPdo()->prepare($sSql);
        $oPdoStatement->execute();
        return ($oPdoStatement->fetchAll());
    }

    public static function chercheParClef(SourceDonnees $oSource, $clef) {
        $sSql = 'SELECT * FROM '.$oSource->getNom().' WHERE '.$oSource->getClefPrimaire().' = :clef';
        $oPdoStatement = $oSource->getPdo()->prepare($sSql);
        $oPdoStatement->bindValue(':clef', $clef);
        $oPdoStatement->execute();
        return($oPdoStatement->fetch());
    }

    public static function chercheParChamps(SourceDonnees $oSource, array $aDonnees) {
        if (!empty($aDonnees)) {
            // Génère une requête SQL avec ces champs
            $sSql = 'SELECT * FROM '.$oSource->getNom().' WHERE ';
            foreach ($aDonnees as $sAttribut => $sValeur) {
                $sSql .= $sAttribut.' = :'.$sAttribut.' AND ';
            }
            $sSql   = preg_replace('/(?> AND )$/', '', $sSql);
            $oPdoStatement  = $oSource->getPdo()->prepare($sSql);
            foreach ($aDonnees as $sAttribut => $sValeur) {
                $oPdoStatement->bindValue(':'.$sAttribut, $sValeur);
            }

            try
            {
                $oPdoStatement->execute();
                return($oPdoStatement->fetchAll());
            }
            catch (\PDOException $e)
            {
                return $e->getMessage();
            }

        }
        else {
            throw new \Exception('Fournir au moins un critère de recherche.');
            return 0;
        }
    }
// U
    public static function modifieEnregistrement(SourceDonnees $oSource, $clef, array $aNouveauxAttributs) {
        $sSql = 'UPDATE '.$oSource->getNom().' SET ';
        if (!empty($aNouveauxAttributs)) {
            foreach ($aNouveauxAttributs as $sAttribut=>$sValeur) {
                if (in_array($sAttribut, $oSource->getAttributs())) {
                    $sSql .= $sAttribut.' = "'.$sValeur.'", ';
                }
            }
            $sSql = preg_replace('/(?>, )$/', '', $sSql);
            $sSql .= ' WHERE '.$oSource->getClefPrimaire().' = '.$clef;
        }
        return ($oSource->getPdo()->exec($sSql));
    }
// D
    public static function supprimeTout(SourceDonnees $oSource) {
        $sSql = 'DELETE FROM '.$oSource->getNom();
        return $oSource->getPdo()->exec($sSql);
    }

    public static function supprimeEnregistrement(SourceDonnees $oSource, $clef) {
        $sSql = 'DELETE FROM '.$oSource->getNom().' WHERE '.$oSource->getClefPrimaire().' = '.$clef;
        return $oSource->getPdo()->exec($sSql);
    }
}
